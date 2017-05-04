@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Estudio Model
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($estudioModel, ['route' => ['estudioModels.update', $estudioModel->id], 'method' => 'patch']) !!}

                        @include('estudio_models.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection