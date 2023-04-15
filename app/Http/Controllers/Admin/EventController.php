<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\Models\Eventi;
use Illuminate\Http\RedirectResponse;

/**
 * This controller is responsible for managing restricted area
 * control for ADMIN level users ONLY and uses a simple
 * feature to include behavior.
 */
class EventController extends Controller
{
    /**
     * @var Eventi
     */
    protected Eventi $eventModel;

    /**
     * Constructor to initialize the variable
     */
    public function __construct()
    {
        $this->eventModel = new Eventi();
    }

    //EVENTI

    /**
     * Update an event in the database and redirect to the "all events" page
     *
     * @param EventRequest $request
     * @param int $id
     * @return RedirectResponse
     * @see Eventi::modificaEvento()
     */
    public function edit(EventRequest $request, int $id): RedirectResponse
    {
        if (is_null(Eventi::getEvento($id)->first()))
            return redirect()
                ->route('events')
                ->withErrors('L\'evento non esiste');
        $this->eventModel->edit($request, $id);
        return redirect()
            ->route('events')
            ->with('message', 'Evento modificato');
    }

    /**
     * Insert an event in the database and redirect to the "all events" page
     *
     * @param EventRequest $request
     * @return RedirectResponse
     * @see Eventi::inserisciEvento()
     */
    public function create(EventRequest $request): RedirectResponse
    {
        $this->eventModel->create($request);
        return redirect()
            ->route('events')
            ->with('message', 'Evento inserito');
    }

    /**
     * Delete (NOT DEFINITLY) an event from the database and redirect to the "all events" page
     *
     * @param int $id
     * @return RedirectResponse
     * @see Eventi::eliminaEvento()
     */
    public function delete(int $id): RedirectResponse
    {
        if (Eventi::getEvento($id)->first() === null)
            return redirect()
                ->route('events.')
                ->withErrors('L\'evento non esiste');
        $this->eventModel->eDelete($id);
        return redirect()
            ->route('events')
            ->with('message', 'Evento eliminato');
    }

    /**
     * Delete (DEFINITELY) an event from the database and redirect
     *
     * @param int $id
     * @return RedirectResponse
     * @see Eventi::deleteDefinitely()
     */
    public function defdelete(int $id): RedirectResponse
    {
        $event = Eventi::getEvento($id)->first();
        if (is_null($event))
            return redirect()
                ->route('events')
                ->withErrors('L\'evento non esiste');
        elseif (!$event->deleted)
            return redirect()
                ->route('events')
                ->withErrors('Impossibile eliminare definitivamente l\'evento. L\'evento non è mai stato "eliminato"');
        $this->eventModel->defdelete($id);
        return redirect()
            ->route('events.deleted')
            ->with('message', 'Evento eliminato definitivamente');
    }

    /**
     * Restore an event (NOT DEFINITLY DELETED) from the database and redirect
     *
     * @param int $id
     * @return RedirectResponse
     * @see Eventi::restoreEvent()
     */
    public function restore(int $id): RedirectResponse
    {
        if (Eventi::getEvento($id)->first() === null)
            return redirect()
                ->route('events')
                ->withErrors('L\'evento non esiste');
        elseif (Eventi::getEvento($id)->first()->deleted === 0)
            return redirect()
                ->route('events')
                ->withErrors('Impossibile ripristinare definitivamente l\'evento. L\'evento non è mai stato eliminato');
        $this->eventModel->restore($id);
        return redirect()->route('events.deleted')
            ->with('message', 'Evento ripristinato');
    }
}
