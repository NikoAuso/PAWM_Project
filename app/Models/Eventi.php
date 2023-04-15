<?php

namespace App\Models;

use App\Http\Requests\EventRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Includes all the method to manage the events in the database
 *
 * @property int $id
 * @property string $image
 * @property string|null $date
 * @property string $titolo
 * @property string|null $extra
 * @property string|null $discoteca
 * @property string|null $descrizione
 * @property int|null $prevendite
 * @property int $active
 * @property int $deleted
 * @property int $isJolly
 * @property int $pagato
 * @property string $created_by
 * @property string $updated_by
 * @property string|null $created_at
 * @property string $updated_at
 *
 */
class Eventi extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'events';
    /**
     * @var string
     */
    protected $primaryKey = 'id';
    /**
     * @var bool
     */
    public $incrementing = true;
    /**
     * @var string
     */
    protected $keyType = 'int';
    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $connection = 'mysql';

    /**
     * Gets all the available events from the database.
     *
     * @return array|Collection
     */
    public static function getEvents(): array|Collection
    {
        return self::query()
            ->where('deleted', false)
            ->orderBy('date', 'DESC')
            ->get();
    }

    /**
     * Gets all the deleted events from the database.
     *
     * @return Collection|array
     */
    public static function getDeletedEvents(): Collection|array
    {
        return self::query()
            ->where('deleted', true)
            ->orderBy('date', 'DESC')
            ->get();
    }

    /**
     * Gets all the future events from the database.
     *
     * @return Collection|array
     */
    public static function getEventsNext(): Collection|array
    {
        return self::query()
            ->where('date', '>', date("Y-m-d"))
            ->where('deleted', false)
            ->orderBy('date', 'ASC')
            ->get();
    }

    /**
     * Gets all the passed events from the database.
     *
     * @return Collection|array
     */
    public static function getEventsOld(): Collection|array
    {
        return self::query()
            ->where('date', '<=', date("Y-m-d"))
            ->where('deleted', false)
            ->orderBy('date', 'DESC')
            ->get();
    }

    /**
     * Gets all the jolly events from the database.
     *
     * @return Collection|array
     */
    public static function getEventsJolly(): Collection|array
    {
        return self::query()
            ->where('isJolly', true)
            ->get();
    }

    /**
     * Gets a specified event from a given id from the database.
     *
     * @param int $id
     * @return Collection|array
     */
    public static function getEvento(int $id): Collection|array
    {
        return self::query()
            ->where('id', $id)
            ->get();
    }

    /**
     * Insert an event into the database.
     * The method also log the event insertion
     *
     * @param EventRequest $request
     * @return void
     */
    public function create(EventRequest $request): void
    {
        $imageName = 'event_placeholder';
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'event_' . str_replace('.', '', microtime(true));
            Image::make($image)->encode('webp')->save(public_path() . '/assets/img/events/' . $imageName . '.webp');
        }
        self::query()
            ->insert([
                'image' => $imageName . '.webp',
                'titolo' => $request->titolo,
                'extra' => $request->extra,
                'date' => $request->date,
                'discoteca' => $request->discoteca,
                'descrizione' => $request->descrizione,
                'prevendite' => $request->prevendite,
                'active' => $request->boolean('active'),
                'pagato' => $request->boolean('pagato'),
                'isJolly' => $request->boolean('isJolly'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'created_by' => Auth::id(),
                'updated_by' => Auth::id()
            ]);

        $eventId = self::query()
            ->latest('id')
            ->first();
        $this->logEventsDetails($eventId->id, 'inserito');
    }

    /**
     * Edit an event identified by id from the database.
     * The method also log the event modification
     *
     * @param EventRequest $request
     * @param int $id
     * @return void
     */
    public function edit(EventRequest $request, int $id): void
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $this->searchAndDeleteOldEventImage($id);
            $imageName = 'event_' . str_replace('.', '', microtime(true));
            Image::make($image)->encode('webp')->save(public_path() . '/assets/img/events/' . $imageName . '.webp');
            self::query()
                ->where('id', $id)
                ->update([
                    'image' => $imageName . '.webp'
                ]);
        }
        self::query()
            ->where('id', $id)
            ->update([
                'titolo' => $request->titolo,
                'extra' => $request->extra,
                'date' => $request->date,
                'discoteca' => $request->discoteca,
                'descrizione' => $request->descrizione,
                'prevendite' => $request->prevendite,
                'pagato' => $request->boolean('pagato'),
                'active' => $request->boolean('active'),
                'isJolly' => $request->boolean('isJolly'),
                    'updated_by' => Auth::id()
            ]);
        $this->logEventsDetails($id, 'modificato');
    }

    /**
     * Delete an event identified by id from the database.
     * The method also log the event deletion
     *
     * @param int $id
     * @return void
     */
    public function eDelete(int $id): void
    {
        self::query()
            ->where('id', $id)
            ->update([
                'deleted' => true
            ]);

        $this->logEventsDetails($id, 'eliminato');
    }

    /**
     * Definitely delete an event identified by id from the database.
     * The method also log the event definitely deletion.
     *
     * @param int $id
     * @return void
     */
    public function defdelete(int $id): void
    {
        $this->searchAndDeleteOldEventImage($id);
        $event = self::getEvento($id)->first();
        $routeUser = route('users.profile', Auth::id());
        self::query()
            ->where('id', $id)
            ->delete();

        Log::info('Evento eliminato definitivamente: ' . $event->titolo . ' --> da: <a href="' . $routeUser . '">' . Auth::user()->username . '</a>');
    }

    /**
     * Restore an event identified by id from the database.
     * The method also log the event restoration
     *
     * @param int $id
     * @return void
     */
    public function restore(int $id): void
    {
        self::query()
            ->where('id', $id)
            ->update([
                'deleted' => false
            ]);

        $this->logEventsDetails($id, 'ripristinato');
    }

    /**
     * Search and delete old event image of the event that are about to be eliminated.
     *
     * @param int $id
     * @return void
     */
    public function searchAndDeleteOldEventImage(int $id): void
    {
        $oldImageName = self::getEvento($id)->first();
        if ($oldImageName->image != 'event_placeholder.webp') {
            if (file_exists('/' . env('EVENT_IMG_FOLDER') . $oldImageName->image))
                unlink('/' . env('EVENT_IMG_FOLDER') . $oldImageName->image);
        }
    }

    /**
     * Log all the operation about the event model.
     * It logs information about the event modified and also about who made the change.
     *
     * @param int $eventId
     * @param string $operation
     * @return void
     */
    public function logEventsDetails(int $eventId, string $operation): void
    {
        $event = self::getEvento($eventId)->first();

        $routeEvents = route('events.edit', $event->id);
        $routeUser = route('users.profile', Auth::id());

        Log::info('Evento ' . $operation . ': <a href="' . $routeEvents . '">' . $event->titolo . '</a> --> da: <a href="' . $routeUser . '">' . Auth::user()->username . '</a>');
    }
}
