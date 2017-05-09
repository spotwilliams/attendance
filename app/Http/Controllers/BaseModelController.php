<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBaseModelRequest;
use App\Http\Requests\UpdateBaseModelRequest;
use App\Repositories\BaseModelRepository;
use Cat\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class BaseModelController extends AppBaseController
{
    /** @var  BaseModelRepository */
    private $baseModelRepository;

    public function __construct(BaseModelRepository $baseModelRepo)
    {
        $this->baseModelRepository = $baseModelRepo;
    }

    /**
     * Display a listing of the BaseModel.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->baseModelRepository->pushCriteria(new RequestCriteria($request));
        $baseModels = $this->baseModelRepository->all();

        return view('base_models.index')
            ->with('baseModels', $baseModels);
    }

    /**
     * Show the form for creating a new BaseModel.
     *
     * @return Response
     */
    public function create()
    {
        return view('base_models.create');
    }

    /**
     * Store a newly created BaseModel in storage.
     *
     * @param CreateBaseModelRequest $request
     *
     * @return Response
     */
    public function store(CreateBaseModelRequest $request)
    {
        $input = $request->all();

        $baseModel = $this->baseModelRepository->create($input);

        Flash::success('Base Model saved successfully.');

        return redirect(route('baseModels.index'));
    }

    /**
     * Display the specified BaseModel.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $baseModel = $this->baseModelRepository->findWithoutFail($id);

        if (empty($baseModel)) {
            Flash::error('Base Model not found');

            return redirect(route('baseModels.index'));
        }

        return view('base_models.show')->with('baseModel', $baseModel);
    }

    /**
     * Show the form for editing the specified BaseModel.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $baseModel = $this->baseModelRepository->findWithoutFail($id);

        if (empty($baseModel)) {
            Flash::error('Base Model not found');

            return redirect(route('baseModels.index'));
        }

        return view('base_models.edit')->with('baseModel', $baseModel);
    }

    /**
     * Update the specified BaseModel in storage.
     *
     * @param  int              $id
     * @param UpdateBaseModelRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBaseModelRequest $request)
    {
        $baseModel = $this->baseModelRepository->findWithoutFail($id);

        if (empty($baseModel)) {
            Flash::error('Base Model not found');

            return redirect(route('baseModels.index'));
        }

        $baseModel = $this->baseModelRepository->update($request->all(), $id);

        Flash::success('Base Model updated successfully.');

        return redirect(route('baseModels.index'));
    }

    /**
     * Remove the specified BaseModel from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $baseModel = $this->baseModelRepository->findWithoutFail($id);

        if (empty($baseModel)) {
            Flash::error('Base Model not found');

            return redirect(route('baseModels.index'));
        }

        $this->baseModelRepository->delete($id);

        Flash::success('Base Model deleted successfully.');

        return redirect(route('baseModels.index'));
    }
}
