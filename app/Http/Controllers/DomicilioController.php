<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDomicilioRequest;
use App\Http\Requests\UpdateDomicilioRequest;
use App\Repositories\DomicilioRepository;
use Cat\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class DomicilioController extends AppBaseController
{
    /** @var  DomicilioRepository */
    private $domicilioRepository;

    public function __construct(DomicilioRepository $domicilioRepo)
    {
        $this->domicilioRepository = $domicilioRepo;
    }

    /**
     * Display a listing of the Domicilio.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->domicilioRepository->pushCriteria(new RequestCriteria($request));
        $domicilios = $this->domicilioRepository->all();

        return view('domicilios.index')
            ->with('domicilios', $domicilios);
    }

    /**
     * Show the form for creating a new Domicilio.
     *
     * @return Response
     */
    public function create()
    {
        return view('domicilios.create');
    }

    /**
     * Store a newly created Domicilio in storage.
     *
     * @param CreateDomicilioRequest $request
     *
     * @return Response
     */
    public function store(CreateDomicilioRequest $request)
    {
        $input = $request->all();

        $domicilio = $this->domicilioRepository->create($input);

        Flash::success('Domicilio saved successfully.');

        return redirect(route('domicilios.index'));
    }

    /**
     * Display the specified Domicilio.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $domicilio = $this->domicilioRepository->findWithoutFail($id);

        if (empty($domicilio)) {
            Flash::error('Domicilio not found');

            return redirect(route('domicilios.index'));
        }

        return view('domicilios.show')->with('domicilio', $domicilio);
    }

    /**
     * Show the form for editing the specified Domicilio.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $domicilio = $this->domicilioRepository->findWithoutFail($id);

        if (empty($domicilio)) {
            Flash::error('Domicilio not found');

            return redirect(route('domicilios.index'));
        }

        return view('domicilios.edit')->with('domicilio', $domicilio);
    }

    /**
     * Update the specified Domicilio in storage.
     *
     * @param  int              $id
     * @param UpdateDomicilioRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDomicilioRequest $request)
    {
        $domicilio = $this->domicilioRepository->findWithoutFail($id);

        if (empty($domicilio)) {
            Flash::error('Domicilio not found');

            return redirect(route('domicilios.index'));
        }

        $domicilio = $this->domicilioRepository->update($request->all(), $id);

        Flash::success('Domicilio updated successfully.');

        return redirect(route('domicilios.index'));
    }

    /**
     * Remove the specified Domicilio from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $domicilio = $this->domicilioRepository->findWithoutFail($id);

        if (empty($domicilio)) {
            Flash::error('Domicilio not found');

            return redirect(route('domicilios.index'));
        }

        $this->domicilioRepository->delete($id);

        Flash::success('Domicilio deleted successfully.');

        return redirect(route('domicilios.index'));
    }
}
