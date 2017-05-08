<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateJornadaLaborableRequest;
use App\Http\Requests\UpdateJornadaLaborableRequest;
use App\Repositories\JornadaLaborableRepository;
use Cat\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class JornadaLaborableController extends AppBaseController
{
    /** @var  JornadaLaborableRepository */
    private $jornadaLaborableRepository;

    public function __construct(JornadaLaborableRepository $jornadaLaborableRepo)
    {
        $this->jornadaLaborableRepository = $jornadaLaborableRepo;
    }

    /**
     * Display a listing of the JornadaLaborable.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->jornadaLaborableRepository->pushCriteria(new RequestCriteria($request));
        $jornadaLaborables = $this->jornadaLaborableRepository->all();

        return view('jornada_laborables.index')
            ->with('jornadaLaborables', $jornadaLaborables);
    }

    /**
     * Show the form for creating a new JornadaLaborable.
     *
     * @return Response
     */
    public function create()
    {
        return view('jornada_laborables.create');
    }

    /**
     * Store a newly created JornadaLaborable in storage.
     *
     * @param CreateJornadaLaborableRequest $request
     *
     * @return Response
     */
    public function store(CreateJornadaLaborableRequest $request)
    {
        $input = $request->all();

        $jornadaLaborable = $this->jornadaLaborableRepository->create($input);

        Flash::success('Jornada Laborable saved successfully.');

        return redirect(route('jornadaLaborables.index'));
    }

    /**
     * Display the specified JornadaLaborable.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $jornadaLaborable = $this->jornadaLaborableRepository->findWithoutFail($id);

        if (empty($jornadaLaborable)) {
            Flash::error('Jornada Laborable not found');

            return redirect(route('jornadaLaborables.index'));
        }

        return view('jornada_laborables.show')->with('jornadaLaborable', $jornadaLaborable);
    }

    /**
     * Show the form for editing the specified JornadaLaborable.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $jornadaLaborable = $this->jornadaLaborableRepository->findWithoutFail($id);

        if (empty($jornadaLaborable)) {
            Flash::error('Jornada Laborable not found');

            return redirect(route('jornadaLaborables.index'));
        }

        return view('jornada_laborables.edit')->with('jornadaLaborable', $jornadaLaborable);
    }

    /**
     * Update the specified JornadaLaborable in storage.
     *
     * @param  int              $id
     * @param UpdateJornadaLaborableRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateJornadaLaborableRequest $request)
    {
        $jornadaLaborable = $this->jornadaLaborableRepository->findWithoutFail($id);

        if (empty($jornadaLaborable)) {
            Flash::error('Jornada Laborable not found');

            return redirect(route('jornadaLaborables.index'));
        }

        $jornadaLaborable = $this->jornadaLaborableRepository->update($request->all(), $id);

        Flash::success('Jornada Laborable updated successfully.');

        return redirect(route('jornadaLaborables.index'));
    }

    /**
     * Remove the specified JornadaLaborable from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $jornadaLaborable = $this->jornadaLaborableRepository->findWithoutFail($id);

        if (empty($jornadaLaborable)) {
            Flash::error('Jornada Laborable not found');

            return redirect(route('jornadaLaborables.index'));
        }

        $this->jornadaLaborableRepository->delete($id);

        Flash::success('Jornada Laborable deleted successfully.');

        return redirect(route('jornadaLaborables.index'));
    }
}
