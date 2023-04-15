<?php

use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\ListeController;
use App\Http\Controllers\Admin\TavoliController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['auth', 'verified'], 'api/'], function () {
    Route::group(['middleware' =>  ['role:admin|super-admin', 'permission:manage-users'], 'prefix' => 'utenti/'], function () {
        Route::post('insert/{page}', [UserController::class, 'create'])->name('create-user');
        Route::post('edit/{id}/{page}', [UserController::class, 'edit'])->name('edit-user');
        Route::post('delete/{id}/{page}', [UserController::class, 'delete'])->name('delete-user');
        Route::post('def_delete/{id}', [UserController::class, 'defdelete'])->name('definitely-delete-user');
        Route::post('restore/{id}', [UserController::class, 'restore'])->name('restore-user');
    });
    Route::group(['middleware' =>  ['role:admin|super-admin', 'permission:manage-events'], 'prefix' => 'events/'], function () {
        Route::post('insert', [EventController::class, 'create'])->name('create-event');
        Route::post('edit/{id}', [EventController::class, 'edit'])->name('edit-event');
        Route::get('delete/{id}', [EventController::class, 'eDelete'])->name('delete-event');
        Route::get('def_delete/{id}', [EventController::class, 'defdelete'])->name('definitely-delete-event');
        Route::get('restore/{id}', [EventController::class, 'restore'])->name('restore-event');
    });
    Route::group(['middleware' =>  ['role:admin|super-admin', 'permission:manage-tavoli'], 'prefix' => 'tavoli/'], function () {
        Route::post('insert', [TavoliController::class, 'inserisciTavolo'])->name('create-tavolo');
        Route::post('deit/{id}', [TavoliController::class, 'modificaTavolo'])->name('edit-tavolo');
        Route::get('delete/{id}', [TavoliController::class, 'eliminaTavolo'])->name('delete-tavolo');
        Route::get('restore/{id}', [TavoliController::class, 'restoreTavolo'])->name('restore-tavolo');
        Route::get('def_delete/{id}', [TavoliController::class, 'eliminaDefinitivamenteTavolo'])->name('definitely-delete-tavolo');
        Route::post('store_season', [TavoliController::class, 'chiudiStagione'])->name('store');
    });
    Route::group(['middleware' =>  ['role:admin|super-admin', 'permission:manage-liste'], 'prefix' => 'liste/'], function () {
        Route::post('insert', [ListeController::class, 'create'])->name('create-lista');
        Route::post('edit/{id}', [ListeController::class, 'edit'])->name('edit-lista');
        Route::get('delete/{id}', [ListeController::class, 'delete'])->name('delete-lista');
    });
});
