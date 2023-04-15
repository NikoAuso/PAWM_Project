<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

/**
 * This controller is responsible for managing restricted area
 * control for ADMIN level users ONLY and uses a simple
 * feature to include behavior.
 */
class UserController extends Controller
{
    /**
     * @var User
     */
    protected User $userModel;

    /**
     * Constructor to initialize the variable
     */
    public function __construct()
    {
        $this->userModel = new User();
    }

    //UTENTI

    /**
     * Function that insert new user and redirect to the page depending on the last page viewed
     *
     * @param UserRequest $request
     * @param $page
     * @return RedirectResponse
     */
    public function create(UserRequest $request, $page): RedirectResponse
    {
        $this->userModel->create($request);
        $page_final = match ($page) {
            'pr' => 'users.pr',
            'admin' => 'users.admin'
        };
        return redirect()
            ->route($page_final)
            ->with('message', 'Utente inserito. La password di default è impostata a "Mamateam2023!"');
    }

    /**
     * Function that edit the user selected by id and redirect to the page depending on the last page viewed
     *
     * @param UserRequest $request
     * @param $id
     * @param $page
     * @return RedirectResponse
     */
    public function edit(UserRequest $request, $id, $page): RedirectResponse
    {
        $this->userModel->edit($request, $id);
        $page_final = match ($page) {
            'pr' => 'users.pr',
            'admin' => 'users.admin'
        };
        return redirect()
            ->route($page_final)
            ->with('message', 'Utente modificato');
    }

    /**
     * Function that deactivate the user selected by id and redirect to the page depending on the last page viewed
     *
     * @param $id
     * @param $page
     * @return RedirectResponse
     */
    public function delete($id, $page): RedirectResponse
    {
        $page_final = match ($page) {
            'pr' => 'users.pr',
            'admin' => 'users.admin'
        };
        if (User::query()->where('id', $id)->exists()) {
            $this->userModel->deactivateUser($id);
            return redirect()->route($page_final)
                ->with('message', 'Utente disattivato');
        } else {
            return redirect()->route($page_final)
                ->withErrors('L\'utente non esiste');
        }
    }

    /**
     * Function that definitely delete the user selected by id and redirect to the "deleted user" page
     *
     * @param $id
     * @return RedirectResponse
     */
    public function defdelete($id): RedirectResponse
    {
        if (User::query()->where('id', $id)->exists()) {
            $this->userModel->defdelete($id);
            return redirect()->route('users.deleted')
                ->with('message', 'Utente eliminato definitivamente');
        } else {
            return redirect()->route('users.deleted')
                ->withErrors('L\'utente non esiste');
        }
    }

    /**
     * Function that restore the user selected by id and redirect to the "deleted user" page
     *
     * @param $id
     * @return RedirectResponse
     */
    public function restore($id): RedirectResponse
    {
        if (User::query()->where('id', $id)->exists()) {
            $this->userModel->reactivateUser($id);
            return redirect()->route('users.deleted')
                ->with('message', 'Utente riattivato');
        } else {
            return redirect()->route('users.deleted')
                ->withErrors('L\'utente non esiste');
        }
    }
}
