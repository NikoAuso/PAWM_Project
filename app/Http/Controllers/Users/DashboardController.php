<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Eventi;
use App\Models\Liste;
use App\Models\Tavoli;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

/**
 * This is the controller that manage the home page of the website.
 */
class DashboardController extends Controller
{
    /**
     * @var Eventi
     */
    protected Eventi $eventModel;

    /**
     * @var Liste
     */
    protected Liste $listeModel;

    /**
     * @var Tavoli
     */
    protected Tavoli $tavoliModel;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->eventModel = new Eventi();
        $this->listeModel = new Liste();
        $this->tavoliModel = new Tavoli();
    }

    public function index(): string
    {
        $data = [
            'allEvents' => $this->eventModel->getEvents()->count(),
            'allListe' => $this->listeModel->getListByUserId(Auth::id())->count(),
            'allTavoli' => $this->tavoliModel->getTavoloByUserId(Auth::id())->count()
        ];
        return view('pr/dashboard')
            ->with($data);
    }

}
