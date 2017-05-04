<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDomicilioModelRequest;
use App\Http\Requests\UpdateDomicilioModelRequest;
use App\Repositories\DomicilioModelRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class DomicilioModelController extends AppBaseController
{
    /** @var  DomicilioModelRepository */
    private $domicilioModelRepository;

    public function __construct(DomicilioModelRepository $domicilioModelRepo)
    {
        $this->domicilioModelRepository = $domicilioModelRepo;
    }

    /**
     * Display a listing of the DomicilioModel.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->domicilioModelRepository->pushCriteria(new RequestCriteria($request));
        $domicilioModels = $this->domicilioModelRepository->all();

        return view('domicilio_models.index')
            ->with('domicilioModels', $domicilioModels);
    }

    /**
     * Show the form for creating a new DomicilioModel.
     *
     * @return Response
     */
    public function create()
    {
        return view('domicilio_models.create');
    }

    /**
     * Store a newly created DomicilioModel in storage.
     *
     * @param CreateDomicilioModelRequest $request
     *
     * @return Response
     */
    public function store(CreateDomicilioModelRequest $request)
    {
        $input = $request->all();

        $domicilioModel = $this->domicilioModelRepository->create($input);

        Flash::success('Domicilio Model saved successfully.');

        return redirect(route('domicilioModels.index'));
    }

    /**
     * Display the specified DomicilioModel.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $domicilioModel = $this->domicilioModelRepository->findWithoutFail($id);

        if (empty($domicilioModel)) {
            Flash::error('Domicilio Model not found');

            return redirect(route('domicilioModels.index'));
        }

        return view('domicilio_models.show')->with('domicilioModel', $domicilioModel);
    }

    /**
     * Show the form for editing the specified DomicilioModel.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $domicilioModel = $this->domicilioModelRepository->findWithoutFail($id);

        if (empty($domicilioModel)) {
            Flash::error('Domicilio Model not found');

            return redirect(route('domicilioModels.index'));
        }

        return view('domicilio_models.edit')->with('domicilioModel', $domicilioModel);
    }

    /**
     * Update the specified DomicilioModel in storage.
     *
     * @param  int              $id
     * @param UpdateDomicilioModelRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDomicilioModelRequest $request)
    {
        $domicilioModel = $this->domicilioModelRepository->findWithoutFail($id);

        if (empty($domicilioModel)) {
            Flash::error('Domicilio Model not found');

            return redirect(route('domicilioModels.index'));
        }

        $domicilioModel = $this->domicilioModelRepository->update($request->all(), $id);

        Flash::success('Domicilio Model updated successfully.');

        return redirect(route('domicilioModels.index'));
    }

    /**
     * Remove the specified DomicilioModel from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $domicilioModel = $this->domicilioModelRepository->findWithoutFail($id);

        if (empty($domicilioModel)) {
            Flash::error('Domicilio Model not found');

            return redirect(route('domicilioModels.index'));
        }

        $this->domicilioModelRepository->delete($id);

        Flash::success('Domicilio Model deleted successfully.');

        return redirect(route('domicilioModels.index'));
    }
}
