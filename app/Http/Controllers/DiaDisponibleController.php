<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDiaDisponibleRequest;
use App\Http\Requests\UpdateDiaDisponibleRequest;
use App\Repositories\DiaDisponibleRepository;
use Cat\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class DiaDisponibleController extends AppBaseController
{
    /** @var  DiaDisponibleRepository */
    private $diaDisponibleRepository;

    public function __construct(DiaDisponibleRepository $diaDisponibleRepo)
    {
        $this->diaDisponibleRepository = $diaDisponibleRepo;
    }

    /**
     * Display a listing of the DiaDisponible.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->diaDisponibleRepository->pushCriteria(new RequestCriteria($request));
        $diaDisponibles = $this->diaDisponibleRepository->all();

        return view('dia_disponibles.index')
            ->with('diaDisponibles', $diaDisponibles);
    }

    /**
     * Show the form for creating a new DiaDisponible.
     *
     * @return Response
     */
    public function create()
    {
        return view('dia_disponibles.create');
    }

    /**
     * Store a newly created DiaDisponible in storage.
     *
     * @param CreateDiaDisponibleRequest $request
     *
     * @return Response
     */
    public function store(CreateDiaDisponibleRequest $request)
    {
        $input = $request->all();

        $diaDisponible = $this->diaDisponibleRepository->create($input);

        Flash::success('Dia Disponible saved successfully.');

        return redirect(route('diaDisponibles.index'));
    }

    /**
     * Display the specified DiaDisponible.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $diaDisponible = $this->diaDisponibleRepository->findWithoutFail($id);

        if (empty($diaDisponible)) {
            Flash::error('Dia Disponible not found');

            return redirect(route('diaDisponibles.index'));
        }

        return view('dia_disponibles.show')->with('diaDisponible', $diaDisponible);
    }

    /**
     * Show the form for editing the specified DiaDisponible.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $diaDisponible = $this->diaDisponibleRepository->findWithoutFail($id);

        if (empty($diaDisponible)) {
            Flash::error('Dia Disponible not found');

            return redirect(route('diaDisponibles.index'));
        }

        return view('dia_disponibles.edit')->with('diaDisponible', $diaDisponible);
    }

    /**
     * Update the specified DiaDisponible in storage.
     *
     * @param  int              $id
     * @param UpdateDiaDisponibleRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDiaDisponibleRequest $request)
    {
        $diaDisponible = $this->diaDisponibleRepository->findWithoutFail($id);

        if (empty($diaDisponible)) {
            Flash::error('Dia Disponible not found');

            return redirect(route('diaDisponibles.index'));
        }

        $diaDisponible = $this->diaDisponibleRepository->update($request->all(), $id);

        Flash::success('Dia Disponible updated successfully.');

        return redirect(route('diaDisponibles.index'));
    }

    /**
     * Remove the specified DiaDisponible from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $diaDisponible = $this->diaDisponibleRepository->findWithoutFail($id);

        if (empty($diaDisponible)) {
            Flash::error('Dia Disponible not found');

            return redirect(route('diaDisponibles.index'));
        }

        $this->diaDisponibleRepository->delete($id);

        Flash::success('Dia Disponible deleted successfully.');

        return redirect(route('diaDisponibles.index'));
    }
}
