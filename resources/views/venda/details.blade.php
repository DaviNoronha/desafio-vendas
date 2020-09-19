@extends('adminlte::page')

@section('title', 'Detalhes da Venda')

@section('content_header')
    <h1>Detalhes da Venda</h1>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-body">
            <div class="form-group">
                <label for="pessoa_id">Cliente</label>
                <input class="form-control" type="text" value="{{ $venda->cliente->nome }}" readonly>
            </div>

            <div class="form-group">
                <label for="observacao">Observação</label>
                <textarea class="form-control" rows="3" readonly>{{ $venda->observacao }}</textarea>
            </div>

            <div class="row">
                <div class="form-group col-sm-4">
                    <label for="pessoa_id">Desconto</label>
                    <input class="form-control" type="text" value="{{ number_format($venda->desconto, 2, ',', '.') }}" readonly>
                </div>
                <div class="form-group col-sm-4">
                    <label for="pessoa_id">Acréscimo</label>
                    <input class="form-control" type="text" value="{{ number_format($venda->acrescimo, 2, ',', '.') }}" readonly>
                </div>
                <div class="form-group col-sm-4">
                    <label for="pessoa_id">Total</label>
                    <input class="form-control" type="text" value="{{ number_format($venda->total, 2, ',', '.') }}" readonly>
                </div>
            </div>

            <table class="table table-sm table-bordered">
                <thead class="thead-dark">
                    <th>Produto</th>
                    <th class="text-center">Quantidade</th>
                    <th class="text-center">Valor Unitário</th>
                    <th class="text-center">Valor Total</th>
                </thead>
                <tbody>
                    @foreach ($venda->itensVenda as $item)
                        <tr>
                            <th>{{ $item->produto->descricao }}</th>
                            <th class="text-center">{{ $item->quantidade }}</th>
                            <th class="text-center">R$ {{ number_format($item->valor_unitario, 2, ',', '.') }}</th>
                            <th class="text-center">R$ {{ number_format($item->valor_total, 2, ',', '.') }}</th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            <a class="btn btn-secondary" href="{{ route('vendas.index') }}">Voltar</a>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop