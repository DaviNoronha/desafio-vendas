@extends('adminlte::page')

@section('title', 'PDV')

@section('content_header')
    <h1>PDV</h1>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-body">
            <form action="{{ route('vendas.store') }}" method="post" id="form-venda">
                @csrf
                <div class="form-group">
                    <label for="cliente_id">Cliente</label>
                    <select class="form-control" name="cliente_id" id="select-clientes"></select>
                </div>

                <div class="form-group">
                    <label for="observacao">Observação</label>
                    <textarea class="form-control" name="observacao" id="observacao" rows="2"></textarea>
                </div>

                <div class="form-group">
                    <label for="observacao">Forma de Pagamento</label>
                    <select class="form-control" name="forma_pagamento" id="forma_pagamento" onchange="formaPagamento()">
                        @foreach ($formasPagamento as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <button type="submit" class="btn btn-primary">Finalizar Venda</button>
                    <span id="total-geral" style="font-size: 25px; margin-left: 25px;">Total: 0.0</span>
                    <span id="total-desconto" style="font-size: 25px; margin-left: 25px;">Com Desconto: 0.0</span>
                    <span id="total-acrescimo" style="font-size: 25px; margin-left: 25px;">Com Acréscimo: 0.0</span>
                </div>

                <hr>

                <div class="row mt-3">
                    <div class="col-12">
                        <h3 class="text-success">Produtos da Venda</h3>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="form-group col-sm-4">
                                <label for="pessoa_id">Produtos</label>
                                <select class="form-control" id="select-produtos"></select>
                            </div>
                            <div class="form-group col-sm-2">
                                <label for="pessoa_id">Quantidade</label>
                                <input class="form-control" type="number" id="quantidade_add">
                            </div>
                            <div class="form-group col-sm-1">
                                <label for="pessoa_id">Ação</label>
                                <button type="button" class="btn btn-primary" onclick="adicionarProduto()">Adicionar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Produto</th>
                                    <th>Quantidade</th>
                                    <th>Preço</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody id="itens-venda">
                            </tbody>
                        </table>
                    </div>
                </div>

            </form>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
<script>
    var totalGeral = 0;
    var totalComDesconto = 0;
    var totalComAcrescimo = 0;
    $('#select-clientes').select2({
        ajax: {
            url: '{{ route('lista.clientes') }}',
            dataType: 'json',
            data: function (params) {
                return {
                    searchTerm: params.term
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            },
        }
    });
    $('#select-produtos').select2({
        ajax: {
            url: '{{ route('lista.produtos') }}',
            dataType: 'json',
            data: function (params) {
                return {
                    searchTerm: params.term
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            },
        }
    });
    $('#form-venda').submit(function(event) {
        if (totalGeral == 0) {
            Swal.fire('Ops!', 'A venda precisa ter pelo menos um produto', 'error')
            return false;
        }
        axios.post('{{ route('vendas.store') }}', new FormData(event.target))
            .then((response) => {
                window.location.href = '{{ route('vendas.index') }}'
            })
            .catch((err) => {
                Swal.fire('Ops!', 'Ocorreu um erro ao salvar a venda', 'error')
            })
        return false;
    });
    function adicionarProduto() {
        let produto = $('#select-produtos').val();
        let quantidade = $('#quantidade_add').val();
        if (produto && quantidade) {
            let urlBase = '{{ route('produtos.index') }}'
            axios.get(urlBase + '/' + produto)
                .then((response) => {
                    exibirItem(response.data, quantidade);
                })
                .catch((error) => {
                    Swal.fire('Ops!', 'Erro ao selecionar o produto', 'error')
                });
        } else {
            Swal.fire('Ops!', 'Escolha o produto e informe a quantidade', 'error')
        }
    }
    function exibirItem(produto, quantidade) {
        let total = parseFloat(produto.preco) * quantidade;
        totalGeral += total;
        let item =  "<tr>";
            item += "<th><input class='form-control' value='" + produto.descricao + "' disabled>";
            item += "<input style='display:none' name='produto_id[]' value='" + produto.id + "' readonly></th>";
            item += "<th><input class='form-control' name='quantidade[]' value='" + quantidade + "' readonly></th>";
            item += "<th><input class='form-control' value='" + produto.preco + "' disabled></th>";
            item += "<th><input class='form-control' value='" + total.toFixed(2) + "' disabled></th>";
            item += "</tr>";
        $('#total-geral').html('Total: ' + totalGeral.toFixed(2));
        $('#itens-venda').append(item);
        formaPagamento();
    }
    function formaPagamento() {
        console.log($('#forma_pagamento').val())
        let forma_pagamento = $('#forma_pagamento').val();
        if(totalGeral > 0) {
            if(forma_pagamento == 0) {
                totalComDesconto = totalGeral - 5 / 100 * totalGeral
                $('#total-desconto').html('Com Desconto: ' + totalComDesconto.toFixed(2));
                $('#total-acrescimo').html('Com Acréscimo: 0.0');
            } else if(forma_pagamento == 1) {
                totalComAcrescimo = 10 / 100 * totalGeral + totalGeral
                $('#total-acrescimo').html('Com Acréscimo: ' + totalComAcrescimo.toFixed(2));
                $('#total-desconto').html('Com Desconto: 0.0');
            }
            $('#total-geral').html('Total: ' + totalGeral.toFixed(2));
        }
    }
</script>
@stop