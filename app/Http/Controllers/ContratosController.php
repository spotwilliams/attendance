<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateContratosRequest;
use App\Http\Requests\UpdateContratosRequest;
use App\Repositories\ContratosRepository;
use Cat\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class ContratosController extends AppBaseController
{
    /** @var  ContratosRepository */
    private $contratosRepository;

    public function __construct(ContratosRepository $contratosRepo)
    {
        $this->contratosRepository = $contratosRepo;
    }

    /**
     * Display a listing of the Contratos.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->contratosRepository->pushCriteria(new RequestCriteria($request));
        $contratos = $this->contratosRepository->all();

        return view('contratos.index')
            ->with('contratos', $contratos);
    }

    /**
     * Show the form for creating a new Contratos.
     *
     * @return Response
     */
    public function create()
    {
        return view('contratos.create');
    }

    /**
     * Store a newly created Contratos in storage.
     *
     * @param CreateContratosRequest $request
     *
     * @return Response
     */
    public function store(CreateContratosRequest $request)
    {
        $input = $request->all();

        $contratos = $this->contratosRepository->create($input);

        Flash::success('Contratos saved successfully.');

        return redirect(route('contratos.index'));
    }

    /**
     * Display the specified Contratos.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $contratos = $this->contratosRepository->findWithoutFail($id);

        if (empty($contratos)) {
            Flash::error('Contratos not found');

            return redirect(route('contratos.index'));
        }

        return view('contratos.show')->with('contratos', $contratos);
    }

    /**
     * Show the form for editing the specified Contratos.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $contratos = $this->contratosRepository->findWithoutFail($id);

        if (empty($contratos)) {
            Flash::error('Contratos not found');

            return redirect(route('contratos.index'));
        }

        return view('contratos.edit')->with('contratos', $contratos);
    }

    /**
     * Update the specified Contratos in storage.
     *
     * @param  int              $id
     * @param UpdateContratosRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateContratosRequest $request)
    {
        $contratos = $this->contratosRepository->findWithoutFail($id);

        if (empty($contratos)) {
            Flash::error('Contratos not found');

            return redirect(route('contratos.index'));
        }

        $contratos = $this->contratosRepository->update($request->all(), $id);

        Flash::success('Contratos updated successfully.');

        return redirect(route('contratos.index'));
    }

    /**
     * Remove the specified Contratos from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $contratos = $this->contratosRepository->findWithoutFail($id);

        if (empty($contratos)) {
            Flash::error('Contratos not found');

            return redirect(route('contratos.index'));
        }

        $this->contratosRepository->delete($id);

        Flash::success('Contratos deleted successfully.');

        return redirect(route('contratos.index'));
    }
}
