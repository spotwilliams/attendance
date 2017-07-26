@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Base Model
        </h1>
   </section>
   <div class="content">
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($baseModel, ['route' => ['configuracion.base.update', $baseModel->id], 'method' => 'patch']) !!}

                        @include('Configuracion::bases.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection