<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePresentismoModelRequest;
use App\Http\Requests\UpdatePresentismoModelRequest;
use App\Repositories\PresentismoModelRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class PresentismoModelController extends AppBaseController
{
    /** @var  PresentismoModelRepository */
    private $presentismoModelRepository;

    public function __construct(PresentismoModelRepository $presentismoModelRepo)
    {
        $this->presentismoModelRepository = $presentismoModelRepo;
    }

    /**
     * Display a listing of the PresentismoModel.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->presentismoModelRepository->pushCriteria(new RequestCriteria($request));
        $presentismoModels = $this->presentismoModelRepository->all();

        return view('presentismo_models.index')
            ->with('presentismoModels', $presentismoModels);
    }

    /**
     * Show the form for creating a new PresentismoModel.
     *
     * @return Response
     */
    public function create()
    {
        return view('presentismo_models.create');
    }

    /**
     * Store a newly created PresentismoModel in storage.
     *
     * @param CreatePresentismoModelRequest $request
     *
     * @return Response
     */
    public function store(CreatePresentismoModelRequest $request)
    {
        $input = $request->all();

        $presentismoModel = $this->presentismoModelRepository->create($input);

        Flash::success('Presentismo Model saved successfully.');

        return redirect(route('presentismoModels.index'));
    }

    /**
     * Display the specified PresentismoModel.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $presentismoModel = $this->presentismoModelRepository->findWithoutFail($id);

        if (empty($presentismoModel)) {
            Flash::error('Presentismo Model not found');

            return redirect(route('presentismoModels.index'));
        }

        return view('presentismo_models.show')->with('presentismoModel', $presentismoModel);
    }

    /**
     * Show the form for editing the specified PresentismoModel.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $presentismoModel = $this->presentismoModelRepository->findWithoutFail($id);

        if (empty($presentismoModel)) {
            Flash::error('Presentismo Model not found');

            return redirect(route('presentismoModels.index'));
        }

        return view('presentismo_models.edit')->with('presentismoModel', $presentismoModel);
    }

    /**
     * Update the specified PresentismoModel in storage.
     *
     * @param  int              $id
     * @param UpdatePresentismoModelRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePresentismoModelRequest $request)
    {
        $presentismoModel = $this->presentismoModelRepository->findWithoutFail($id);

        if (empty($presentismoModel)) {
            Flash::error('Presentismo Model not found');

            return redirect(route('presentismoModels.index'));
        }

        $presentismoModel = $this->presentismoModelRepository->update($request->all(), $id);

        Flash::success('Presentismo Model updated successfully.');

        return redirect(route('presentismoModels.index'));
    }

    /**
     * Remove the specified PresentismoModel from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $presentismoModel = $this->presentismoModelRepository->findWithoutFail($id);

        if (empty($presentismoModel)) {
            Flash::error('Presentismo Model not found');

            return redirect(route('presentismoModels.index'));
        }

        $this->presentismoModelRepository->delete($id);

        Flash::success('Presentismo Model deleted successfully.');

        return redirect(route('presentismoModels.index'));
    }
}
