<?php

namespace App\DataTables;

use App\Models\Produto;
use Collective\Html\FormFacade;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProdutoDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($p) {
                $acoes = link_to(route('produtos.edit', $p),'Editar', ['class' => 'btn btn-sm btn-primary mr-1']);
                $acoes .= FormFacade::button('Excluir', ['class' => 'btn btn-sm btn-danger', 'onclick' => "excluir('" . route('produtos.destroy', $p) . "')"]);

                return $acoes;
            });
    }

    public function query(Produto $produto)
    {
        return $produto->join('fabricantes', 'produtos.fabricante_id', 'fabricantes.id')
                        ->select(
                            'produtos.id',
                            'produtos.descricao',
                            'produtos.estoque',
                            'produtos.preco',
                            'fabricantes.nome'
                        );
    }

    public function html()
    {
        return $this->builder()
                    ->setTableId('produto-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('create')
                        ->addClass('btn bg-primary')
                        ->text('<i class="fas fa-plus mr-1"></i>Cadastrar novo'),

                        Button::make('export')
                        ->addClass('btn bg-primary')
                        ->text('<i class="fas fa-download mr-1"></i>Exportar'),

                        Button::make('print')                        
                        ->addClass('btn bg-primary')
                        ->text('<i class="fas fa-print mr-1"></i>Imprimir'),
                    );
    }

    protected function getColumns()
    {
        return [
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->addClass('text-center')
                  ->title('Ações'),
            Column::make('descricao'),
            Column::make('estoque'),
            Column::make('preco'),
            Column::make('nome')->name('fabricantes.nome')
        ];
    }

    protected function filename()
    {
        return 'Produto_' . date('YmdHis');
    }
}