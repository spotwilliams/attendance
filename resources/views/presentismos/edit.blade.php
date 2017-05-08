@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Presentismo
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($presentismo, ['route' => ['presentismos.update', $presentismo->id], 'method' => 'patch']) !!}

                        @include('presentismos.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection