<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEstudioModelRequest;
use App\Http\Requests\UpdateEstudioModelRequest;
use App\Repositories\EstudioModelRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class EstudioModelController extends AppBaseController
{
    /** @var  EstudioModelRepository */
    private $estudioModelRepository;

    public function __construct(EstudioModelRepository $estudioModelRepo)
    {
        $this->estudioModelRepository = $estudioModelRepo;
    }

    /**
     * Display a listing of the EstudioModel.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->estudioModelRepository->pushCriteria(new RequestCriteria($request));
        $estudioModels = $this->estudioModelRepository->all();

        return view('estudio_models.index')
            ->with('estudioModels', $estudioModels);
    }

    /**
     * Show the form for creating a new EstudioModel.
     *
     * @return Response
     */
    public function create()
    {
        return view('estudio_models.create');
    }

    /**
     * Store a newly created EstudioModel in storage.
     *
     * @param CreateEstudioModelRequest $request
     *
     * @return Response
     */
    public function store(CreateEstudioModelRequest $request)
    {
        $input = $request->all();

        $estudioModel = $this->estudioModelRepository->create($input);

        Flash::success('Estudio Model saved successfully.');

        return redirect(route('estudioModels.index'));
    }

    /**
     * Display the specified EstudioModel.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $estudioModel = $this->estudioModelRepository->findWithoutFail($id);

        if (empty($estudioModel)) {
            Flash::error('Estudio Model not found');

            return redirect(route('estudioModels.index'));
        }

        return view('estudio_models.show')->with('estudioModel', $estudioModel);
    }

    /**
     * Show the form for editing the specified EstudioModel.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $estudioModel = $this->estudioModelRepository->findWithoutFail($id);

        if (empty($estudioModel)) {
            Flash::error('Estudio Model not found');

            return redirect(route('estudioModels.index'));
        }

        return view('estudio_models.edit')->with('estudioModel', $estudioModel);
    }

    /**
     * Update the specified EstudioModel in storage.
     *
     * @param  int              $id
     * @param UpdateEstudioModelRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateEstudioModelRequest $request)
    {
        $estudioModel = $this->estudioModelRepository->findWithoutFail($id);

        if (empty($estudioModel)) {
            Flash::error('Estudio Model not found');

            return redirect(route('estudioModels.index'));
        }

        $estudioModel = $this->estudioModelRepository->update($request->all(), $id);

        Flash::success('Estudio Model updated successfully.');

        return redirect(route('estudioModels.index'));
    }

    /**
     * Remove the specified EstudioModel from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $estudioModel = $this->estudioModelRepository->findWithoutFail($id);

        if (empty($estudioModel)) {
            Flash::error('Estudio Model not found');

            return redirect(route('estudioModels.index'));
        }

        $this->estudioModelRepository->delete($id);

        Flash::success('Estudio Model deleted successfully.');

        return redirect(route('estudioModels.index'));
    }
}
