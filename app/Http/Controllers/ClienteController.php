<?php

namespace App\Http\Controllers;

use App\DataTables\ClienteDataTable;
use App\Http\Requests\ClienteRequest;
use App\Models\Cliente;
use App\Services\ClienteService;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index(ClienteDataTable $clienteDataTable)
    {
        return $clienteDataTable->render('cliente.index');
    }

    public function create()
    {
        return view('cliente.form');
    }

    public function store(ClienteRequest $request)
    {
        $cliente = ClienteService::store($request->all());

        if ($cliente) {
            flash('Cliente cadastrado com sucesso')->success();

            return back();
        }

        flash('Erro ao salvar o cliente')->error();

        return back()->withInput();
    }

    public function show(Cliente $cliente)
    {
        //
    }

    public function edit(Cliente $cliente)
    {
        return view('cliente.form', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $cliente = ClienteService::update($request->all(), $cliente);

        if ($cliente) {
            flash('Cliente atualizado com sucesso')->success();

            return back();
        }

        flash('Erro ao atualizar o cliente')->error();

        return back()->withInput();
    }

    public function destroy(Cliente $cliente)
    {
        //
    }

    public function listaClientes(Request $request)
    {
        return ClienteService::listaClientes($request->all());
    }
}