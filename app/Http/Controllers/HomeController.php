<?php

namespace App\Http\Controllers;

use App\Models\Eventi;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

/**
 * This is the controller that manage the home page of the website.
 */
class HomeController extends Controller
{
    /**
     * @var Eventi
     */
    protected Eventi $eventModel;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->eventModel = new Eventi;
    }

    /**
     * Show the application home page.
     *
     * @return Factory|View|Application
     */
    public function index(): Factory|View|Application
    {
        $events = $this->eventModel->getEvents()
            ->where('date', '>=', date("Y-m-d"))
            ->where('active', '==', 1);
        $home_events = $events->sortBy('date');
        $active = $home_events->count();

        return view('index')
            ->with('home_events', $home_events)
            ->with('active', $active);
    }

    /**
     * Return the single event view that provides event details.
     *
     * @param $event_id
     * @return Application|Factory|View|void
     */
    public function single_event($event_id)
    {
        $event = $this->eventModel->getEvento($event_id)->first();

        if ($event != null && $event->active == 1) {
            return view('event.singleEvent')
                ->with('event', $event);
        } else {
            abort(403, 'Evento non disponible!');
        }
    }
}
