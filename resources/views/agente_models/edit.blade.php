@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Agente Model
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($agenteModel, ['route' => ['agenteModels.update', $agenteModel->id], 'method' => 'patch']) !!}

                        @include('agente_models.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection