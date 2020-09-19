<?php

namespace App\Http\Controllers;

use App\DataTables\VendaDataTable;
use App\Models\Venda;
use App\Services\VendaService;
use Illuminate\Http\Request;

class VendaController extends Controller
{
    public function index(VendaDataTable $vendaDataTable)
    {
        return $vendaDataTable->render('venda.index');
    }

    public function create()
    {
        return view('venda.form', [
            'formasPagamento' => Venda::FORMAS_PAGAMENTO
        ]);
    }

    public function store(Request $request)
    {
        $venda = VendaService::store($request);

        if ($venda) {
            flash('Venda finalizada com sucesso')->success();
            return response('', 201);
        }

        return response('Erro ao salvar a venda', 400);
    }

    public function show(Venda $venda)
    {
        try {
            return view('venda.details', compact('venda'));
        } catch (\Throwable $th) {
            flash('Ops! Ocorreu um erro ao exibir a venda')->error();
            return back();
        } 
    }
}
