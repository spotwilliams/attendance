@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Domicilio Model
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($domicilioModel, ['route' => ['domicilioModels.update', $domicilioModel->id], 'method' => 'patch']) !!}

                        @include('domicilio_models.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection