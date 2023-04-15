<?php

namespace App\Models;

use App\Http\Requests\ChiudiStagioneRequest;
use App\Http\Requests\TavoloRequest;
use App\Http\Requests\TavoloSearchRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * App\Models\Tavoli
 *
 * @property int $id
 * @property int $event_id
 * @property string $nome
 * @property int $persone
 * @property string|null $etaMedia
 * @property string|null $dettagli
 * @property string $fattoDa
 * @property string $created_by
 * @property string $updated_by
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class Tavoli extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'tavoli_eventi';
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
     * @var string
     */
    protected $connection = 'mysql';

    /**
     * Get all the available table from the database
     *
     * @return array|Collection
     */
    public static function getTavoli(): array|Collection
    {
        return self::query()
            ->join('events as events', 'events.id', '=', 'tavoli_eventi.event_id')
            ->select('tavoli_eventi.id', 'event_id', 'nome', 'persone', 'etaMedia', 'dettagli', 'fattoDa', 'date', 'titolo')
            ->orderBy('events.date', 'desc')
            ->get();
    }

    /**
     * Get all the available table for a specific event from the database
     *
     * @param int $eventId
     * @return array|Collection
     */
    public static function getTavoliForEvent(int $eventId): array|Collection
    {
        return self::query()
            ->where('event_id', $eventId)
            ->get();
    }

    /**
     * Get a specific table from the database
     *
     * @param int $id
     * @return array|Collection
     */
    public static function getTavoloById(int $id): array|Collection
    {
        return self::query()
            ->where('id', $id)
            ->get();
    }

    /**
     * Get all the available table created by an user from the database
     *
     * @param int $user_id
     * @return array|Collection
     */
    public static function getTavoloByUserId(int $user_id): array|Collection
    {
        return self::query()
            ->where('fattoDa', $user_id)
            ->get();
    }

    /**
     * Create a table
     *
     * @param TavoloRequest $request
     * @return void
     */
    public function inserisciTavolo(TavoloRequest $request): void
    {
        self::query()
            ->insert([
                'event_id' => $request->event_id,
                'nome' => $request->nome,
                'persone' => $request->persone,
                'etaMedia' => $request->etaMedia,
                'dettagli' => $request->dettagli,
                'fattoDa' => $request->fattoDa,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'created_by' => Auth::id(),
                'updated_by' => Auth::id()
            ]);
        $tavolo = self::query()
            ->latest('id')
            ->first();
        $this->logTableDetails($tavolo, 'inserito');
    }

    /**
     * Edit a table
     *
     * @param TavoloRequest $request
     * @param $id
     * @return void
     */
    public function modificaTavolo(TavoloRequest $request, $id): void
    {
        self::query()
            ->where('id', $id)
            ->update([
                'nome' => $request->nome,
                'event_id' => $request->event_id,
                'persone' => $request->persone,
                'etaMedia' => $request->etaMedia,
                'dettagli' => $request->dettagli,
                'fattoDa' => $request->fattoDa,
                'updated_by' => Auth::id()
            ]);
        $tavolo = self::getTavoloById($id)
            ->first();
        $this->logTableDetails($tavolo, 'modificato');
    }

    /**
     * Delete a table
     *
     * @param $id
     * @return void
     */
    public function eliminaTavolo($id): void
    {
        $tavolo = self::getTavoloById($id)
            ->first();
        self::query()
            ->where('id', $id)
            ->delete();
        $this->logTableDetails($tavolo, 'eliminato');
    }

    /**
     * Search a table in the database
     *
     * @param TavoloSearchRequest $request
     * @return null
     */
    public static function searchTavolo(TavoloSearchRequest $request)
    {
        if (($request->evento != NULL) && ($request->username != NULL)) {
            return self::query()
                ->join('events as events', 'events.id', '=', 'tavoli_eventi.event_id', 'left')
                ->orderBy('events.date', 'desc')
                ->where('event_id', $request->evento)
                ->where('fattoDa', $request->username)
                ->get();
        } elseif (($request->evento != NULL)) {
            return self::query()
                ->join('events as events', 'events.id', '=', 'tavoli_eventi.event_id', 'left')
                ->orderBy('events.date', 'desc')
                ->where('event_id', $request->evento)
                ->get();
        } elseif (($request->username != NULL)) {
            return self::query()
                ->join('events as events', 'events.id', '=', 'tavoli_eventi.event_id', 'left')
                ->orderBy('events.date', 'desc')
                ->where('fattoDa', $request->username)
                ->get();
        } else {
            return self::query()
                ->join('events as events', 'events.id', '=', 'tavoli_eventi.event_id', 'left')
                ->orderBy('events.date', 'desc')
                ->get();
        }
    }

    /**
     * Close the season and create PDFs
     * @param ChiudiStagioneRequest $details
     * @return bool
     */
    public function chiudiStagione(ChiudiStagioneRequest $details): bool
    {
        $tables = self::all()->values();
        $filename = 'tavoli-stagione-' . str_replace([' ', '/'], '-', strtolower($details->stagione));
        $path = asset('assets/archivio/');

        $this->createCSVFile($tables, $filename, $path);
        $this->createPDFFile($tables, $details, $filename, $path);
        $this->createPDFLeaderboardFile($details, $filename, $path);

        if ($tables->isNotEmpty()) {
            try {
                DB::table('archivio_tavoli')->insert([
                    'nome_stagione' => $details->stagione,
                    'pdf_tavoli' => $filename . '.pdf',
                    'pdf_classifica' => 'classifica_' . $filename . '.pdf',
                    'csv_tavoli' => $filename . '.csv',
                    'dettagli' => $details->dettagliChiusura
                ]);
                self::query()->truncate();
                Log::info('Stagione ' . $details->stagione . ' chiusa. <a href="' . route('archivio') . '">Archivio</a> creato.');
                return true;
            } catch (Exception $e) {
                return false;
            }
        }
        return false;
    }

    /**
     * Create CSV file
     *
     * @param $tables
     * @param $filename
     * @param $path
     * @return void
     */
    public function createCSVFile($tables, $filename, $path): void
    {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename . '.csv');
        header('Pragma: no-cache');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Expires: 0');

        $handle = fopen($path . $filename . '.csv', 'w');

        fputcsv($handle, array('Nome', 'Persone', 'Età media', 'Dettagli', 'Evento', 'Data', 'Fatto da', 'Id Utente', 'Id evento'));

        foreach ($tables as $table) {
            $event = Eventi::getEvento($table->event_id)->first();
            $user = (new User)->getUserByUsername($table->fattoDa)->first();
            $row_table = array(
                $table->nome,
                $table->persone,
                $table->etaMedia,
                $table->dettagli,
                $event->titolo,
                $event->date,
                $user->name . ' ' . $user->surname,
                $user->id,
                $event->id);
            fputcsv($handle, $row_table, ';');
        }
        fclose($handle);
    }

    /**
     * Create PDF file
     *
     * @param $tables
     * @param $details
     * @param $name
     * @param $path
     * @return void
     */
    public function createPDFFile($tables, $details, $name, $path): void
    {
        $file = $path . $name . '.pdf';

        $pdf = PDF::loadView('ar/tavoli/pdf/pdf_table', array(
            'tables' => $tables,
            'stagione' => $details->stagione
        ))->setPaper('A4', 'landscape');

        $pdf->save($file);
    }

    /**
     * Create PDF file of the leaderboard
     *
     * @param $details
     * @param $name
     * @param $path
     * @return void
     */
    public function createPDFLeaderboardFile($details, $name, $path): void
    {
        $file = $path . 'classifica_' . $name . '.pdf';
        $result = self::query()
            ->selectRaw('fattoDa, COUNT(*) as count')
            ->groupBy('fattoDa')
            ->orderBy('count', 'desc')
            ->get();

        $pdf = PDF::loadView('ar/tavoli/pdf/leaderboard', array(
            'tables' => $result,
            'stagione' => $details->stagione
        ))->setPaper('A4', 'landscape');

        $pdf->save($file);
    }

    /**
     * Logging system
     *
     * @param Tavoli $table
     * @param string $operation
     * @return void
     */
    public function logTableDetails(Tavoli $table, string $operation): void
    {
        $evento = Eventi::getEvento($table->event_id)->first();

        Log::info('Tavolo ' . $operation . ': ' . $table->nome .
            ' dell\'evento <a href="' . route('events.edit', $table->event_id) . '">' . $evento->titolo .
            '</a> (' . Carbon::parse($evento->date)->format('d/m/Y') . ') ---> da: <a href="' .
            route('profile', Auth::id()) . '">' . Auth::user()->username . '</a>');
    }
}
