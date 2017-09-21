<?php

namespace Cat\Modules\Presentismo\Controllers\Registro;

use Cat\Helpers\HtmlCustoms;
use Cat\Models\Agente;
use Cat\Models\Comentario;
use Cat\Models\TipoPresentismo;
use Cat\Modules\Presentismo\Exceptions\Validacion\FechaFutura;
use Cat\Modules\Presentismo\Exceptions\Validacion\PeriodoCerrado;
use Cat\Modules\Presentismo\Services\Helpers\Facilitador;
use Cat\Modules\Presentismo\Services\Registro\Destroy;
use Cat\Modules\Presentismo\Services\Validacion\ValidationNonType;
use Cat\Modules\Validation\Repositories\PresentismoRepository;
use Cat\Http\Controllers\AppBaseController;
use Cat\Models\Presentismo;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class ComentarioController extends AppBaseController
{
    /** @var  PresentismoRepository */
    private $presentismoRepository;
    
    public function __construct(PresentismoRepository $presentismoRepo)
    {
        $this->presentismoRepository = $presentismoRepo;
        $this->middleware('auth');
        
    }
    
    public function lista(Request $request, $idPresentismo)
    {
        
        return [
            'data' => Comentario::where('id_presentismo', '=', $idPresentismo)
                ->with('user')
                ->orderBy('created_at', 'ASC')
                ->get(),
        ];
        
    }
    
    
    public function store(Request $request)
    {
//        $this->authorize('store', $this);
        
        $this->validate($request, ['comentario' => 'required|max:255',]);
        $input   = $request->all();
        
        /** @var Presentismo $presentismo */
        $presentismo = Presentismo::find($input['id_presentismo']);
        
        try {
            
            $presentismo->comentario = $input['comentario'];
            
            Comentario::create([
                'id_presentismo' => $presentismo->id,
                'id_user'        => Auth::user()->id,
                'comentario'     => $input['comentario'],
            ]);
            
            $presentismo->comentario = 'SI';
            $presentismo->save();
            $message = 'Guardado correctamente';
            $code    = 200;
        } catch (QueryException $e) {
            $message = $e->getMessage();
            $code    = 500;
        }
        
        return Response::json([
            'message'     => $message,
            'presentismo' => $presentismo,
        ], $code);
        
    }
    
}
