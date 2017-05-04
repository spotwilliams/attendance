@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Presentismo Model
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($presentismoModel, ['route' => ['presentismoModels.update', $presentismoModel->id], 'method' => 'patch']) !!}

                        @include('presentismo_models.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection