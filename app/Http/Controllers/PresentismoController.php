<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePresentismoRequest;
use App\Http\Requests\UpdatePresentismoRequest;
use App\Repositories\PresentismoRepository;
use Cat\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class PresentismoController extends AppBaseController
{
    /** @var  PresentismoRepository */
    private $presentismoRepository;

    public function __construct(PresentismoRepository $presentismoRepo)
    {
        $this->presentismoRepository = $presentismoRepo;
    }

    /**
     * Display a listing of the Presentismo.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->presentismoRepository->pushCriteria(new RequestCriteria($request));
        $presentismos = $this->presentismoRepository->all();

        return view('presentismos.index')
            ->with('presentismos', $presentismos);
    }

    /**
     * Show the form for creating a new Presentismo.
     *
     * @return Response
     */
    public function create()
    {
        return view('presentismos.create');
    }

    /**
     * Store a newly created Presentismo in storage.
     *
     * @param CreatePresentismoRequest $request
     *
     * @return Response
     */
    public function store(CreatePresentismoRequest $request)
    {
        $input = $request->all();

        $presentismo = $this->presentismoRepository->create($input);

        Flash::success('Presentismo saved successfully.');

        return redirect(route('presentismos.index'));
    }

    /**
     * Display the specified Presentismo.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $presentismo = $this->presentismoRepository->findWithoutFail($id);

        if (empty($presentismo)) {
            Flash::error('Presentismo not found');

            return redirect(route('presentismos.index'));
        }

        return view('presentismos.show')->with('presentismo', $presentismo);
    }

    /**
     * Show the form for editing the specified Presentismo.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $presentismo = $this->presentismoRepository->findWithoutFail($id);

        if (empty($presentismo)) {
            Flash::error('Presentismo not found');

            return redirect(route('presentismos.index'));
        }

        return view('presentismos.edit')->with('presentismo', $presentismo);
    }

    /**
     * Update the specified Presentismo in storage.
     *
     * @param  int              $id
     * @param UpdatePresentismoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePresentismoRequest $request)
    {
        $presentismo = $this->presentismoRepository->findWithoutFail($id);

        if (empty($presentismo)) {
            Flash::error('Presentismo not found');

            return redirect(route('presentismos.index'));
        }

        $presentismo = $this->presentismoRepository->update($request->all(), $id);

        Flash::success('Presentismo updated successfully.');

        return redirect(route('presentismos.index'));
    }

    /**
     * Remove the specified Presentismo from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $presentismo = $this->presentismoRepository->findWithoutFail($id);

        if (empty($presentismo)) {
            Flash::error('Presentismo not found');

            return redirect(route('presentismos.index'));
        }

        $this->presentismoRepository->delete($id);

        Flash::success('Presentismo deleted successfully.');

        return redirect(route('presentismos.index'));
    }
}
