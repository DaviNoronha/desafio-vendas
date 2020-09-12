@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')
<h1>Formulário de Cliente</h1>
@stop

@section('content')

    <div class="card card-primary">
        @if (isset($cliente))
            {!! Form::model($cliente, ['url' => route('clientes.update', $cliente), 'method' => 'put']) !!}
        @else
            {!! Form::open(['url' => route('clientes.store')]) !!}
        @endif

        <div class='card-body'>
            <div class="form-group">
                {!! Form::label('nome', 'Nome')!!}
                {!! Form::text('nome', null, ['class' => 'form-control']) !!}
                
                @error('nome')
                    <small class="form-text text-danger">{{$message}}</small>
                
                @enderror

            </div>

            <div class="form-group">
                {!! Form::label('telefone', 'Telefone')!!}
                {!! Form::text('telefone', null, ['class' => 'form-control']) !!}
                
                @error('telefone')
                    <small class="form-text text-danger">{{$message}}</small>
                
                @enderror

            </div>

            <div class="form-group">
                {!! Form::label('email', 'Email')!!}
                {!! Form::text('email', null, ['class' => 'form-control']) !!}
                
                @error('email')
                    <small class="form-text text-danger">{{$message}}</small>
                
                @enderror

            </div>

            <div class="form-group">
                {!! Form::label('cep', 'CEP')!!}
                {!! Form::text('cep', null, ['class' => 'form-control']) !!}
                
                @error('cep')
                    <small class="form-text text-danger">{{$message}}</small>
                
                @enderror

            </div>

            <div class="form-group">
                {!! Form::label('cpf', 'CPF')!!}
                {!! Form::text('cpf', null, ['class' => 'form-control', 'onfocusout' => 'buscaCep()']) !!}
                
                @error('cpf')
                    <small class="form-text text-danger">{{$message}}</small>
                
                @enderror

            </div>

            <div class="form-group">
                {!! Form::label('logradouro', 'Logradouro')!!}
                {!! Form::text('logradouro', null, ['class' => 'form-control']) !!}
                
                @error('logradouro')
                    <small class="form-text text-danger">{{$message}}</small>
                
                @enderror

            </div>

            <div class="form-group">
                {!! Form::label('bairro', 'Bairro')!!}
                {!! Form::text('bairro', null, ['class' => 'form-control']) !!}
                
                @error('bairro')
                    <small class="form-text text-danger">{{$message}}</small>
                
                @enderror

            </div>

            <div class="form-group">
                {!! Form::label('localidade', 'Localidade')!!}
                {!! Form::text('localidade', null, ['class' => 'form-control']) !!}
                
                @error('localidade')
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
    function buscaCep() {
        let cep = document.getElementById('cep').value;
        let url = 'https://viacep.com.br/ws/' + cep + '/json/';
        axios.get(url)
        .then(function (response) {
            document.getElementById('logradouro').value = response.data.logradouro
            document.getElementById('bairro').value = response.data.bairro
            document.getElementById('localidade').value = response.data.localidade
        })
        .catch(function (error) {
            alert('Ops! CEP não encontrado');
        })
    }
</script>
@stop