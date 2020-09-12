@extends('adminlte::page')

@section('title', 'Fabricantes')

@section('content_header')
    <h1>Formulário de Fabricante</h1>
@stop

@section('content')

    <div class="card card-primary">
        @if (isset($fabricante))
            {!! Form::model($fabricante, ['url' => route('fabricantes.update', $fabricante), 'method' => 'put']) !!}
        @else
            {!! Form::open(['url' => route('fabricantes.store')]) !!}
        @endif

        <div class="card-body">
            <div class="form-group">
                {!! Form::label('nome', 'Nome')!!}
                {!! Form::text('nome', null, ['class' => 'form-control']) !!}
                
                @error('nome')
                    <small class="form-text text-danger">{{$message}}</small>
                
                @enderror

            </div>

            <div class="form-group">
                {!! Form::label('site', 'Site')!!}
                {!! Form::text('site', null, ['class' => 'form-control']) !!}
                
                @error('site')
                    <small class="form-text text-danger">{{$message}}</small>
                
                @enderror
                
            </div>
        </div>

        <div class="card-footer">
            {!! Form::submit('Salvar', ['class' => 'btn btn-primary'])!!}
        </div>

        {!! Form::close() !!}
    </div>
@stop

@section('css')

@stop

@section('js')
    <script>
        function testeAlert() {
            Swal.fire(
                'Good job!',
                'You clicked the button!',
                'success'
                )
        }
    </script>
        
@stop