<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateContratosModelRequest;
use App\Http\Requests\UpdateContratosModelRequest;
use App\Repositories\ContratosModelRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class ContratosModelController extends AppBaseController
{
    /** @var  ContratosModelRepository */
    private $contratosModelRepository;

    public function __construct(ContratosModelRepository $contratosModelRepo)
    {
        $this->contratosModelRepository = $contratosModelRepo;
    }

    /**
     * Display a listing of the ContratosModel.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->contratosModelRepository->pushCriteria(new RequestCriteria($request));
        $contratosModels = $this->contratosModelRepository->all();

        return view('contratos_models.index')
            ->with('contratosModels', $contratosModels);
    }

    /**
     * Show the form for creating a new ContratosModel.
     *
     * @return Response
     */
    public function create()
    {
        return view('contratos_models.create');
    }

    /**
     * Store a newly created ContratosModel in storage.
     *
     * @param CreateContratosModelRequest $request
     *
     * @return Response
     */
    public function store(CreateContratosModelRequest $request)
    {
        $input = $request->all();

        $contratosModel = $this->contratosModelRepository->create($input);

        Flash::success('Contratos Model saved successfully.');

        return redirect(route('contratosModels.index'));
    }

    /**
     * Display the specified ContratosModel.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $contratosModel = $this->contratosModelRepository->findWithoutFail($id);

        if (empty($contratosModel)) {
            Flash::error('Contratos Model not found');

            return redirect(route('contratosModels.index'));
        }

        return view('contratos_models.show')->with('contratosModel', $contratosModel);
    }

    /**
     * Show the form for editing the specified ContratosModel.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $contratosModel = $this->contratosModelRepository->findWithoutFail($id);

        if (empty($contratosModel)) {
            Flash::error('Contratos Model not found');

            return redirect(route('contratosModels.index'));
        }

        return view('contratos_models.edit')->with('contratosModel', $contratosModel);
    }

    /**
     * Update the specified ContratosModel in storage.
     *
     * @param  int              $id
     * @param UpdateContratosModelRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateContratosModelRequest $request)
    {
        $contratosModel = $this->contratosModelRepository->findWithoutFail($id);

        if (empty($contratosModel)) {
            Flash::error('Contratos Model not found');

            return redirect(route('contratosModels.index'));
        }

        $contratosModel = $this->contratosModelRepository->update($request->all(), $id);

        Flash::success('Contratos Model updated successfully.');

        return redirect(route('contratosModels.index'));
    }

    /**
     * Remove the specified ContratosModel from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $contratosModel = $this->contratosModelRepository->findWithoutFail($id);

        if (empty($contratosModel)) {
            Flash::error('Contratos Model not found');

            return redirect(route('contratosModels.index'));
        }

        $this->contratosModelRepository->delete($id);

        Flash::success('Contratos Model deleted successfully.');

        return redirect(route('contratosModels.index'));
    }
}
