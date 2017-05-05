<?php

namespace Cat\Http\Controllers;

use Cat\Http\Requests\CreatePeriodoModelRequest;
use Cat\Http\Requests\UpdatePeriodoModelRequest;
use Cat\Repositories\PeriodoModelRepository;
use Cat\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class PeriodoModelController extends AppBaseController
{
    /** @var  PeriodoModelRepository */
    private $periodoModelRepository;

    public function __construct(PeriodoModelRepository $periodoModelRepo)
    {
        $this->periodoModelRepository = $periodoModelRepo;
    }

    /**
     * Display a listing of the PeriodoModel.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->periodoModelRepository->pushCriteria(new RequestCriteria($request));
        $periodoModels = $this->periodoModelRepository->all();

        return view('periodo_models.index')
            ->with('periodoModels', $periodoModels);
    }

    /**
     * Show the form for creating a new PeriodoModel.
     *
     * @return Response
     */
    public function create()
    {
        return view('periodo_models.create');
    }

    /**
     * Store a newly created PeriodoModel in storage.
     *
     * @param CreatePeriodoModelRequest $request
     *
     * @return Response
     */
    public function store(CreatePeriodoModelRequest $request)
    {
        $input = $request->all();

        $periodoModel = $this->periodoModelRepository->create($input);

        Flash::success('Periodo Model saved successfully.');

        return redirect(route('periodoModels.index'));
    }

    /**
     * Display the specified PeriodoModel.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $periodoModel = $this->periodoModelRepository->findWithoutFail($id);

        if (empty($periodoModel)) {
            Flash::error('Periodo Model not found');

            return redirect(route('periodoModels.index'));
        }

        return view('periodo_models.show')->with('periodoModel', $periodoModel);
    }

    /**
     * Show the form for editing the specified PeriodoModel.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $periodoModel = $this->periodoModelRepository->findWithoutFail($id);

        if (empty($periodoModel)) {
            Flash::error('Periodo Model not found');

            return redirect(route('periodoModels.index'));
        }

        return view('periodo_models.edit')->with('periodoModel', $periodoModel);
    }

    /**
     * Update the specified PeriodoModel in storage.
     *
     * @param  int              $id
     * @param UpdatePeriodoModelRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePeriodoModelRequest $request)
    {
        $periodoModel = $this->periodoModelRepository->findWithoutFail($id);

        if (empty($periodoModel)) {
            Flash::error('Periodo Model not found');

            return redirect(route('periodoModels.index'));
        }

        $periodoModel = $this->periodoModelRepository->update($request->all(), $id);

        Flash::success('Periodo Model updated successfully.');

        return redirect(route('periodoModels.index'));
    }

    /**
     * Remove the specified PeriodoModel from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $periodoModel = $this->periodoModelRepository->findWithoutFail($id);

        if (empty($periodoModel)) {
            Flash::error('Periodo Model not found');

            return redirect(route('periodoModels.index'));
        }

        $this->periodoModelRepository->delete($id);

        Flash::success('Periodo Model deleted successfully.');

        return redirect(route('periodoModels.index'));
    }
}
