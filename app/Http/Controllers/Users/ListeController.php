<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ListeRequest;
use App\Models\Liste;
use Illuminate\Http\RedirectResponse;

/**
 * This controller is responsible for managing restricted area
 * control for ADMIN level users ONLY and uses a simple
 * feature to include behavior to manage lists of the events.
 */
class ListeController extends Controller
{
    /**
     * @var Liste
     */
    protected Liste $listModel;

    /**
     * Constructor to initialize the variable
     */
    public function __construct()
    {
        $this->listModel = new Liste();
    }

    /**
     * @param ListeRequest $request
     * @return RedirectResponse
     */
    public function create(ListeRequest $request): RedirectResponse
    {
        $this->listModel->create($request);
        return redirect()->back()
            ->with('message', 'Lista aggiunta');
    }

    /**
     * @param ListeRequest $request
     * @return RedirectResponse
     */
    public function edit(ListeRequest $request): RedirectResponse
    {
        $this->listModel->edit($request);
        return redirect()->back()
            ->with('message', 'Lista modificata');
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function delete(int $id): RedirectResponse
    {
        $this->listModel->lDelete($id);
        return redirect()->back()
            ->with('message', 'Lista eliminata');
    }
}
