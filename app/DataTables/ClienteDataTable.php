<?php

namespace App\DataTables;

use App\Models\Cliente;
use Collective\Html\FormFacade;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ClienteDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($c) {
                $acoes = link_to(route('clientes.edit', $c),'Editar', ['class' => 'btn btn-sm btn-primary mr-1']);
                $acoes .= FormFacade::button('Excluir', ['class' => 'btn btn-sm btn-danger', 'onclick' => "excluir('" . route('clientes.destroy', $c) . "')"]);

                return $acoes;
            });
    }

    public function query(Cliente $model)
    {
        return $model->newQuery();
    }

    public function html()
    {
        return $this->builder()
                    ->setTableId('cliente-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('create')
                            ->addClass('btn btn-primary')
                            ->text('<i class="fas fa-plus-circle"></i> Cadastrar Novo'),
                        Button::make('export')
                            ->addClass('btn btn-primary')
                            ->text('<i class="fas fa-download"></i> Exportar'),
                        Button::make('print')
                            ->addClass('btn btn-primary')
                            ->text('<i class="fas fa-print"></i> Imprimir')
                    );
    }

    protected function getColumns()
    {
        return [
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->addClass('text-center'),
            Column::make('nome'),
            Column::make('email'),
            Column::make('telefone')
        ];
    }

    protected function filename()
    {
        return 'Cliente_' . date('YmdHis');
    }
}