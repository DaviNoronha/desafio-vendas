<?php

namespace App\Http\Controllers;

use App\DataTables\ClienteDataTable;
use App\Http\Requests\ClienteRequest;
use App\Models\Cliente;
use App\Services\ClienteService;
use Illuminate\Http\Request;
use Throwable;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
            flash ('Seu perfil foi cadastrado com sucesso!')->success();
            
            return back();
        }

        flash ('Erro ao cadastrar seu perfil!')->error();

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
            flash ('Seu perfil foi atualizado com sucesso!')->success();
            
            return back();
        }

        flash ('Erro ao atualizar seu perfil!')->error();

        return back()->withInput();

    }

    public function destroy(Cliente $cliente)
    {
        try {
            $cliente->delete();
        } catch (Throwable $th) {
            return response('Erro ao apagar', 400);
        }    }
}
