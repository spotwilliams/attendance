@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Contratos Model
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($contratosModel, ['route' => ['contratosModels.update', $contratosModel->id], 'method' => 'patch']) !!}

                        @include('contratos_models.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection