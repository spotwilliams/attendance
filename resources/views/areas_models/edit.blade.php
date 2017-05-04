@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Areas Model
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($areasModel, ['route' => ['areasModels.update', $areasModel->id], 'method' => 'patch']) !!}

                        @include('areas_models.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection