@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Domicilio
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($domicilio, ['route' => ['domicilios.update', $domicilio->id], 'method' => 'patch']) !!}

                        @include('domicilios.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection