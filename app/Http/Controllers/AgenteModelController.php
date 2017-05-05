<?php

namespace Cat\Http\Controllers;

use Cat\Http\Requests\CreateAgenteModelRequest;
use Cat\Http\Requests\UpdateAgenteModelRequest;
use Cat\Repositories\AgenteModelRepository;
use Cat\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class AgenteModelController extends AppBaseController
{
    /** @var  AgenteModelRepository */
    private $agenteModelRepository;

    public function __construct(AgenteModelRepository $agenteModelRepo)
    {
        $this->agenteModelRepository = $agenteModelRepo;
    }

    /**
     * Display a listing of the AgenteModel.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->agenteModelRepository->pushCriteria(new RequestCriteria($request));
        $agenteModels = $this->agenteModelRepository->all();

        return view('agente_models.index')
            ->with('agenteModels', $agenteModels);
    }

    /**
     * Show the form for creating a new AgenteModel.
     *
     * @return Response
     */
    public function create()
    {
        return view('agente_models.create');
    }

    /**
     * Store a newly created AgenteModel in storage.
     *
     * @param CreateAgenteModelRequest $request
     *
     * @return Response
     */
    public function store(CreateAgenteModelRequest $request)
    {
        $input = $request->all();

        $agenteModel = $this->agenteModelRepository->create($input);

        Flash::success('Agente Model saved successfully.');

        return redirect(route('agenteModels.index'));
    }

    /**
     * Display the specified AgenteModel.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $agenteModel = $this->agenteModelRepository->findWithoutFail($id);

        if (empty($agenteModel)) {
            Flash::error('Agente Model not found');

            return redirect(route('agenteModels.index'));
        }

        return view('agente_models.show')->with('agenteModel', $agenteModel);
    }

    /**
     * Show the form for editing the specified AgenteModel.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $agenteModel = $this->agenteModelRepository->findWithoutFail($id);

        if (empty($agenteModel)) {
            Flash::error('Agente Model not found');

            return redirect(route('agenteModels.index'));
        }

        return view('agente_models.edit')->with('agenteModel', $agenteModel);
    }

    /**
     * Update the specified AgenteModel in storage.
     *
     * @param  int              $id
     * @param UpdateAgenteModelRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAgenteModelRequest $request)
    {
        $agenteModel = $this->agenteModelRepository->findWithoutFail($id);

        if (empty($agenteModel)) {
            Flash::error('Agente Model not found');

            return redirect(route('agenteModels.index'));
        }

        $agenteModel = $this->agenteModelRepository->update($request->all(), $id);

        Flash::success('Agente Model updated successfully.');

        return redirect(route('agenteModels.index'));
    }

    /**
     * Remove the specified AgenteModel from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $agenteModel = $this->agenteModelRepository->findWithoutFail($id);

        if (empty($agenteModel)) {
            Flash::error('Agente Model not found');

            return redirect(route('agenteModels.index'));
        }

        $this->agenteModelRepository->delete($id);

        Flash::success('Agente Model deleted successfully.');

        return redirect(route('agenteModels.index'));
    }
}
