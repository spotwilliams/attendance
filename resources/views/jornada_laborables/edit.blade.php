@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Jornada Laborable
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($jornadaLaborable, ['route' => ['jornadaLaborables.update', $jornadaLaborable->id], 'method' => 'patch']) !!}

                        @include('jornada_laborables.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection