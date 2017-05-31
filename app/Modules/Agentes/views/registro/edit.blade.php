@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Agente
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-warning">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($agente, ['route' => ['agentesEdit', $agente->id], 'method' => 'post']) !!}
{{----}}
                        {{--@include('agentes.fields')--}}
{{----}}
                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection