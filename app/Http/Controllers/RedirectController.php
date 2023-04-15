<?php

namespace App\Http\Controllers;

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
class RedirectController extends Controller
{
    /**
     * @var User
     */
    protected User $userModel;

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
        $this->userModel = new User();
        $this->eventModel = new Eventi();
        $this->listeModel = new Liste();
        $this->tavoliModel = new Tavoli();
    }
    public function redirect(): string
    {
        if(Auth::user()->getRoleNames()->get(0) == 'admin') {
            return (new Admin\DashboardController)->index();
        }elseif (Auth::user()->getRoleNames()->get(0) == 'pr'){
            return (new Users\DashboardController)->index();
        }else{
            return redirect()->back()->withErrors('Errore generico');
        }
    }
}
