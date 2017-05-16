<?php

namespace Cat\Modules\Presentismo\Controllers\Registro;

use App\Http\Requests\CreatePresentismoRequest;
use App\Http\Requests\UpdatePresentismoRequest;
use Cat\Modules\Validation\Rules\PresentismoRepository;
use Cat\Http\Controllers\AppBaseController;
use Cat\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Support\Facades\Response;

class RegistroController extends AppBaseController
{
    /** @var  PresentismoRepository */
    private $presentismoRepository;
    
    public function __construct(PresentismoRepository $presentismoRepo)
    {
        $this->presentismoRepository = $presentismoRepo;
        $this->middleware('auth');
        
    }
    
    /**
     * Display a listing of the Presentismo.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request, $base)
    {
        $this->presentismoRepository->pushCriteria(new RequestCriteria($request));
        $presentismos = $this->presentismoRepository->all();
        
        return view('Presentismo::registro.index')
            ->with('presentismos', $presentismos)
            ->with('agentes', $this->presentismoRepository
                ->agentesAptos($base))
            ->with('baseActual', $base);
    }
    
    /**
     * Show the form for creating a new Presentismo.
     *
     * @return Response
     */
    public function create()
    {
        return view('Presentismo::registro.create');
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
        
        return redirect(route('Presentismo::registro.index'));
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
            
            return redirect(route('Presentismo::registro.index'));
        }
        
        return view('Presentismo::registro.show')->with('presentismo', $presentismo);
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
            
            return redirect(route('Presentismo::registro.index'));
        }
        
        return view('Presentismo::registro.edit')->with('presentismo', $presentismo);
    }
    
    /**
     * Update the specified Presentismo in storage.
     *
     * @param  int $id
     * @param UpdatePresentismoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePresentismoRequest $request)
    {
        $presentismo = $this->presentismoRepository->findWithoutFail($id);
        
        if (empty($presentismo)) {
            Flash::error('Presentismo not found');
            
            return redirect(route('Presentismo::registro.index'));
        }
        
        $presentismo = $this->presentismoRepository->update($request->all(), $id);
        
        Flash::success('Presentismo updated successfully.');
        
        return redirect(route('Presentismo::registro.index'));
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
            
            return redirect(route('Presentismo::registro.index'));
        }
        
        $this->presentismoRepository->delete($id);
        
        Flash::success('Presentismo deleted successfully.');
        
        return redirect(route('Presentismo::registro.index'));
    }
}
