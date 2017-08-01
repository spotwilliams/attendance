<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAreasRequest;
use App\Http\Requests\UpdateAreasRequest;
use App\Repositories\AreaRepository;
use Cat\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class AreasController extends AppBaseController
{
    /** @var  AreaRepository */
    private $areasRepository;

    public function __construct(AreaRepository $areasRepo)
    {
        $this->middleware('auth');
        $this->areasRepository = $areasRepo;
    }

    /**
     * Display a listing of the Areas.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->areasRepository->pushCriteria(new RequestCriteria($request));
        $areas = $this->areasRepository->all();

        return view('areas.index')
            ->with('areas', $areas);
    }

    /**
     * Show the form for creating a new Areas.
     *
     * @return Response
     */
    public function create()
    {
        return view('areas.create');
    }

    /**
     * Store a newly created Areas in storage.
     *
     * @param CreateAreasRequest $request
     *
     * @return Response
     */
    public function store(CreateAreasRequest $request)
    {
        $input = $request->all();

        $areas = $this->areasRepository->create($input);

        Flash::success('Areas saved successfully.');

        return redirect(route('areas.index'));
    }

    /**
     * Display the specified Areas.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $areas = $this->areasRepository->findWithoutFail($id);

        if (empty($areas)) {
            Flash::error('Areas not found');

            return redirect(route('areas.index'));
        }

        return view('areas.show')->with('areas', $areas);
    }

    /**
     * Show the form for editing the specified Areas.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $areas = $this->areasRepository->findWithoutFail($id);

        if (empty($areas)) {
            Flash::error('Areas not found');

            return redirect(route('areas.index'));
        }

        return view('areas.edit')->with('areas', $areas);
    }

    /**
     * Update the specified Areas in storage.
     *
     * @param  int              $id
     * @param UpdateAreasRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAreasRequest $request)
    {
        $areas = $this->areasRepository->findWithoutFail($id);

        if (empty($areas)) {
            Flash::error('Areas not found');

            return redirect(route('areas.index'));
        }

        $areas = $this->areasRepository->update($request->all(), $id);

        Flash::success('Areas updated successfully.');

        return redirect(route('areas.index'));
    }

    /**
     * Remove the specified Areas from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $areas = $this->areasRepository->findWithoutFail($id);

        if (empty($areas)) {
            Flash::error('Areas not found');

            return redirect(route('areas.index'));
        }

        $this->areasRepository->delete($id);

        Flash::success('Areas deleted successfully.');

        return redirect(route('areas.index'));
    }
}
