<?php

namespace Cat\Http\Controllers;

use Cat\Http\Requests\CreateAreasModelRequest;
use Cat\Http\Requests\UpdateAreasModelRequest;
use Cat\Repositories\AreasModelRepository;
use Cat\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class AreasModelController extends AppBaseController
{
    /** @var  AreasModelRepository */
    private $areasModelRepository;

    public function __construct(AreasModelRepository $areasModelRepo)
    {
        $this->areasModelRepository = $areasModelRepo;
    }

    /**
     * Display a listing of the AreasModel.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->areasModelRepository->pushCriteria(new RequestCriteria($request));
        $areasModels = $this->areasModelRepository->all();

        return view('areas_models.index')
            ->with('areasModels', $areasModels);
    }

    /**
     * Show the form for creating a new AreasModel.
     *
     * @return Response
     */
    public function create()
    {
        return view('areas_models.create');
    }

    /**
     * Store a newly created AreasModel in storage.
     *
     * @param CreateAreasModelRequest $request
     *
     * @return Response
     */
    public function store(CreateAreasModelRequest $request)
    {
        $input = $request->all();

        $areasModel = $this->areasModelRepository->create($input);

        Flash::success('Areas Model saved successfully.');

        return redirect(route('areasModels.index'));
    }

    /**
     * Display the specified AreasModel.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $areasModel = $this->areasModelRepository->findWithoutFail($id);

        if (empty($areasModel)) {
            Flash::error('Areas Model not found');

            return redirect(route('areasModels.index'));
        }

        return view('areas_models.show')->with('areasModel', $areasModel);
    }

    /**
     * Show the form for editing the specified AreasModel.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $areasModel = $this->areasModelRepository->findWithoutFail($id);

        if (empty($areasModel)) {
            Flash::error('Areas Model not found');

            return redirect(route('areasModels.index'));
        }

        return view('areas_models.edit')->with('areasModel', $areasModel);
    }

    /**
     * Update the specified AreasModel in storage.
     *
     * @param  int              $id
     * @param UpdateAreasModelRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAreasModelRequest $request)
    {
        $areasModel = $this->areasModelRepository->findWithoutFail($id);

        if (empty($areasModel)) {
            Flash::error('Areas Model not found');

            return redirect(route('areasModels.index'));
        }

        $areasModel = $this->areasModelRepository->update($request->all(), $id);

        Flash::success('Areas Model updated successfully.');

        return redirect(route('areasModels.index'));
    }

    /**
     * Remove the specified AreasModel from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $areasModel = $this->areasModelRepository->findWithoutFail($id);

        if (empty($areasModel)) {
            Flash::error('Areas Model not found');

            return redirect(route('areasModels.index'));
        }

        $this->areasModelRepository->delete($id);

        Flash::success('Areas Model deleted successfully.');

        return redirect(route('areasModels.index'));
    }
}
