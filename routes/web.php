<?php

use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\ListeController;
use App\Http\Controllers\Admin\TavoliController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Requests\ListeSearchRequest;
use App\Http\Requests\TavoloSearchRequest;
use App\Models\Eventi;
use App\Models\Liste;
use App\Models\Tavoli;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;
use function PHPUnit\Framework\isNull;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Home
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/event_{id}', [HomeController::class, 'single_event'])->name('singleEvent');

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('dashboard', [RedirectController::class, 'redirect'])->name('dashboard');

    //Admin
    Route::group(['middleware' => ['role:admin'], 'prefix' => 'admin/'], function () {
        //Logs
        Route::get('logs', [LogViewerController::class, 'index'])->name('logs');

        Route::group(['prefix' => 'utenti/', 'as' => 'users.'], function () {
            Route::get('pr', function () {
                $data = [
                    'users' => User::role('pr')->get(),
                    'title' => 'PR'
                ];
                return view('ar/users/users_display')->with($data);
            })->name('pr');

            Route::get('admin', function () {
                $data = [
                    'users' => User::role('admin')->get(),
                    'title' => 'Admin'
                ];
                return view('ar/users/users_display')->with($data);
            })->name('admin');

            Route::get('deleted', function () {
                $data = [
                    'users' => User::getInactiveUsers()->values(),
                    'title' => 'PR eliminati'
                ];
                return view('ar/users/deleted_users_display')->with($data);
            })->name('deleted');

            Route::get('insert/{page}', function ($page) {
                return view('ar/users/add_user')
                    ->with('page', $page);
            })->name('insert');

            Route::get('edit/{id}/{page}', function ($id, $page) {
                $user = User::getUserById($id)->first();
                if ($user->hasRole('super-admin'))
                    abort(401, 'Utente non modificabile');
                elseif (empty($user))
                    abort(403, 'L\'utente non esiste!');
                return view('ar/users/edit_user')
                    ->with('data', $user)
                    ->with('page', $page);
            })->name('edit');

            Route::get('profile/{id}', function ($id) {
                $user = User::getUserById($id)->first();
                if (empty($user))
                    abort(403, 'L\'utente non esiste!');
                return view('ar/profile/view_profile')
                    ->with('user', $user);
            })->name('profile');
        });

        //Gestione eventi
        Route::get('eventi', function () {
            $data = [
                'events' => Eventi::getEvents(),
                'eventsNext' => Eventi::getEventsNext(),
                'eventsOld' => Eventi::getEventsOld(),
                'jollyEvents' => Eventi::getEventsJolly()
            ];
            return view('ar/event/events_display')
                ->with($data);
        })->name('events');
        Route::group(['prefix' => 'eventi/', 'as' => 'events.'], function () {
            Route::get('table', function () {
                $events = Eventi::getEvents();
                return view('ar/event/events_listTable')
                    ->with('events', $events);
            })->name('table');

            Route::get('calendar', function () {
                $events = Eventi::getEvents();
                $data = array();
                foreach ($events as $event) {
                    if ($event->isJolly == "0")
                        $data = array_merge($data,
                            array(['id' => $event->id,
                                'title' => $event->titolo,
                                'extra' => $event->extra,
                                'date' => $event->date,
                                'dateDay' => Carbon::parse($event->date)->dayName,
                                'dateFull' => Carbon::parse($event->date)->format('d/m/Y'),
                                'dateHour' => Carbon::parse($event->date)->format('H:i'),
                                'discoteca' => $event->discoteca,
                                'descrizione' => $event->descrizione ?? 'Descrizione non aggiunta',
                                'immagine' => $event->image,
                                'allDay' => true])
                        );
                }
                $data = json_encode($data);
                return view('ar/event/events_calendar')
                    ->with('data', $data)
                    ->with('events', $events);
            })->name('calendar');

            Route::get('event/edit/{id}', function ($id) {
                $data = Eventi::getEvento($id)->first();
                if (is_null($data)) {
                    return redirect()
                        ->route('events')
                        ->withErrors('L\'evento non esiste');
                } else {
                    return view('ar/event/event_modify', ['id' => $id, 'data' => $data]);
                }
            })->name('edit');

            Route::get('event/insert', function () {
                return view('ar/event/event_insert');
            })->name('insert');

            Route::get('event/deleted', function () {
                $events = Eventi::getDeletedEvents();
                return view('ar/event/deleted_events_display')
                    ->with('deletedEvents', $events);
            })->name('deleted');
        });

        //Gestione tavoli e classifica
        Route::get('tavoli', function () {
            $table = Tavoli::getTavoli();
            return view('ar/tavoli/all_table_display')
                ->with('tables', $table);
        })->name('tavoli');
        Route::get('archivio', function () {
            $result = DB::table('archivio_tavoli')->get()->values();
            return view('ar/tavoli/archivio')
                ->with('archivio', $result);
        })->name('archivio');
        Route::get('leaderboard', function () {
            $result = Tavoli::query()
                ->selectRaw('fattoDa, COUNT(*) as count')
                ->groupBy('fattoDa')
                ->orderBy('count', 'desc')
                ->get()
                ->values();
            $date = DB::table('events')
                ->orderBy('date', 'DESC')
                ->where('date', '<=', date(now()))
                ->first();
            return view('ar/tavoli/leaderboard')
                ->with('result', $result)
                ->with('date', $date);
        })->name('leaderboard');
        Route::group(['prefix' => 'tavoli/', 'as' => 'tavoli.'], function () {
            Route::get('event/{id}', function ($id) {
                $table = Tavoli::getTavoliForEvent($id);
                $event = Eventi::getEvento($id)->first();
                return view('ar/tavoli/table_display')
                    ->with('event', $event)
                    ->with('tables', $table);
            })->name('event');
            Route::post('filtered', function (TavoloSearchRequest $request) {
                $result = Tavoli::searchTavolo($request)->values();
                return view('ar/tavoli/all_table_display')
                    ->with('tables', $result);
            })->name('search');
        });

        //Gestione liste
        Route::get('liste', function () {
            $lists = Liste::getLists();
            return view('ar/liste/lists_rel_display')
                ->with('lists', $lists);
        })->name('liste');
        Route::group(['prefix' => 'liste/', 'as' => 'liste.'], function () {
            Route::get('event/{id}', function (int $id) {
                $event = Eventi::getEvento($id)->first();
                if ($event) {
                    $lists = Liste::getListByEventId($id);
                    return view('ar/liste/lists_rel_display_event')
                        ->with('lists', $lists)
                        ->with('event', $event);
                } else {
                    abort(403, 'L\'evento non esiste');
                }
            })->name('event');
            Route::post('search', function (ListeSearchRequest $request) {
                $result = Liste::getListByEventId($request->evento)->values();
                return view('ar/liste/lists_rel_display')
                    ->with('lists', $result);
            })->name('search');
        });
    });

    //Pr
    Route::group(['middleware' => ['role:pr'], 'prefix' => 'pr/'], function () {
        //Gestione tavoli e classifica
        Route::get('tavoli', function () {
            $table = Tavoli::getTavoloByUserId(Auth::id());
            return view('ar/tavoli/all_table_display')
                ->with('tables', $table);
        })->name('tavoli_pr');

        Route::get('leaderboard', function () {
            $result = Tavoli::query()
                ->selectRaw('fattoDa, COUNT(*) as count')
                ->groupBy('fattoDa')
                ->orderBy('count', 'desc')
                ->get()
                ->values();
            $date = DB::table('events')
                ->orderBy('date', 'DESC')
                ->where('date', '<=', date(now()))
                ->first();
            return view('ar/tavoli/leaderboard')
                ->with('result', $result)
                ->with('date', $date);
        })->name('leaderboard_pr');

        //Gestione liste
        Route::get('liste', function () {
            $lists = Liste::getLists();
            return view('ar/liste/lists_rel_display')
                ->with('lists', $lists);
        })->name('liste_pr');
    });

    //Gestione profilo personale
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('profile/update-profile', [ProfileController::class, 'modifyData'])->name('profile_update');
    Route::post('profile/update-social', [ProfileController::class, 'modifyDataSocial'])->name('profile_update_social');
    Route::post('profile/update-avatar', [ProfileController::class, 'updateAvatar'])->name('profile_uploadAvatar');
    Route::get('profile/delete-avatar', [ProfileController::class, 'deleteAvatar'])->name('profile_deleteAvatar');
    Route::get('security', [ProfileController::class, 'mostraSecurity'])->name('security');
    Route::post('security/password-modify', [ProfileController::class, 'passwordChange'])->name('security_change');
});
