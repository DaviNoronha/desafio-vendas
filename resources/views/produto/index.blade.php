@extends('adminlte::page')

@section('title', 'Produtos')

@section('content_header')
    <h1>Produtos</h1>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-body">
            {!! $dataTable->table() !!}
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
    {!! $dataTable->scripts() !!}

    <script>
        function excluir(rota) {
            Swal.fire({
                title: 'Atenção!',
                text: "Deseja mesmo excluir?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim',
                cancelButtonText: 'Não'
            }).then((result) => {
                if (result.value === true) {
                    axios.delete(rota)
                        .then(function (res) {
                            $('#' + Object.keys(window.LaravelDataTables)[0]).DataTable().ajax.reload()
                            Swal.fire('Sucesso!', 'Apagado com sucesso', 'success')
                        })
                        .catch(function (err) {
                            Swal.fire('Sucesso!', 'Ocorreu um erro ao apagar', 'success')
                        })
                    
                }
            })
        }
    </script>
@stop