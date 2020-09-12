@extends('adminlte::page')

@section('title', 'Formulário de Produto')

@section('content_header')
    <h1>Formulário de Produto</h1>
@stop

@section('content')

    <div class="card card-primary">
        @if (isset($produto))
            {!! Form::model($produto, ['url' => route('produtos.update', $produto), 'method' => 'put']) !!}
        @else
            {!! Form::open(['url' => route('produtos.store')]) !!}
        @endif
            <div class="card-body">
                <div class="form-group">
                    {!! Form::label('descricao', 'Descrição') !!}
                    {!! Form::text('descricao', null, ['class' => 'form-control']) !!}
                    @error('descricao')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    {!! Form::label('estoque', 'Estoque') !!}
                    {!! Form::number('estoque', null, ['class' => 'form-control']) !!}
                    @error('estoque')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    {!! Form::label('preco', 'Preço') !!}
                    {!! Form::number('preco', null, ['class' => 'form-control']) !!}
                    @error('preco')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    {!! Form::label('fabricante_id', 'Fabricante') !!}
                    {!! Form::select('fabricante_id', $fabricantes, null, ['class' => 'form-control']) !!}
                    @error('fabricante_id')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
            </div>
        {!! Form::close() !!}
    </div>
@stop