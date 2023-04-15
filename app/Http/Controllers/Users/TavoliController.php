<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChiudiStagioneRequest;
use App\Http\Requests\TavoloRequest;
use App\Models\Tavoli;
use Illuminate\Http\RedirectResponse;

/**
 * This controller is responsible for managing restricted area
 * control for ADMIN level users ONLY and uses a simple
 * feature to include behavior.
 */
class TavoliController extends Controller
{
    /**
     * @var Tavoli
     */
    protected Tavoli $tavoloModel;

    /**
     * Constructor to initialize the variable
     */
    public function __construct()
    {
        $this->tavoloModel = new Tavoli();
    }

    //TAVOLI

    /**
     * @param TavoloRequest $request
     * @return RedirectResponse
     */
    public function inserisciTavolo(TavoloRequest $request): RedirectResponse
    {
        $this->tavoloModel->inserisciTavolo($request);
        return redirect()->back()
            ->with('message', 'Tavolo inserito');
    }

    /**
     * @param TavoloRequest $request
     * @param $id
     * @return RedirectResponse
     */
    public function modificaTavolo(TavoloRequest $request, $id): RedirectResponse
    {
        $this->tavoloModel->modificaTavolo($request, $id);
        return redirect()->back()
            ->with('message', 'Tavolo salvato');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function eliminaTavolo($id): RedirectResponse
    {
        $this->tavoloModel->eliminaTavolo($id);
        return redirect()->back()
            ->with('message', 'Tavolo eliminato');
    }


    /**
     * @param ChiudiStagioneRequest $dettagli
     * @return RedirectResponse
     */
    public function chiudiStagione(ChiudiStagioneRequest $dettagli): RedirectResponse
    {
        $r = $this->tavoloModel->chiudiStagione($dettagli);
        if (!$r) {
            $msg = 'Qualcosa è andato storto:
                        <ul>
                            <li>Non ci sono tavoli disponibili</li>
                            <li>Il nome della stagione è uguale a quello di una già archiviata</li>
                        </ul>';
            return redirect()
                ->back()
                ->withErrors($msg);
        } else {
            $msg = 'Tavoli eliminati e <a href="' . route('archivio') . '">archivio</a> creato.</a>';
            return redirect()
                ->route('tavoli')
                ->with(['message' => $msg]);
        }
    }
}
