<?php

namespace App\DataTables;

use App\Models\Venda;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class VendaDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($v) {
                return link_to(route('vendas.show', $v),'Detalhes', ['class' => 'btn btn-sm btn-success mr-1']);
            })
            ->editColumn('forma_pagamento', function ($v) {
                return Venda::FORMAS_PAGAMENTO[$v->forma_pagamento];
            })
            ->editColumn('total', function ($v) {
                return 'R$ ' . number_format($v->total, 2, ',', '.');
            })
            ->editColumn('created_at', function ($v) {
                return $v->created_at->format('d/m/Y');
            });
    }

    public function query(Venda $venda)
    {
        return $venda->join('clientes', 'vendas.cliente_id', 'clientes.id')
                    ->select(
                        'vendas.id',
                        'clientes.nome as cliente',
                        'vendas.forma_pagamento',
                        'vendas.total',
                        'vendas.created_at'
                    );
    }

    public function html()
    {
        return $this->builder()
                    ->setTableId('venda-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('create')
                            ->addClass('btn btn-primary')
                            ->text('<i class="fas fa-plus-circle"></i> Nova Venda')
                    );
    }

    protected function getColumns()
    {
        return [
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center')
                  ->title('Ações'),
            Column::make('cliente')->name('clientes.nome'),
            Column::make('forma_pagamento'),
            Column::make('total'),
            Column::make('created_at')->title('Data')
        ];
    }

    protected function filename()
    {
        return 'Venda_' . date('YmdHis');
    }
}