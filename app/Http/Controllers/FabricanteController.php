<?php

namespace App\Http\Controllers;

use App\DataTables\FabricanteDataTable;
use App\Http\Requests\FabricanteRequest;
use App\Models\Fabricante;
use App\Services\FabricanteService;
use Illuminate\Http\Request;
use Throwable;

class FabricanteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FabricanteDataTable $fabricanteDataTable)
    {
        return $fabricanteDataTable->render('fabricante.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('fabricante.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FabricanteRequest $request) 
    {
        $fabricante = FabricanteService::store($request->all());

        if ($fabricante) {
            flash ('Fabricante criado com sucesso!')->success();

            return back();
        }

            flash ('Erro ao criar o fabricante')->error();

            return back()->withInput();
    }

    public function show(Fabricante $fabricante)
    {
        //
    }

    public function edit(Fabricante $fabricante)
    {
        return view('fabricante.form', compact('fabricante'));
    }

    public function update(Request $request, Fabricante $fabricante)
    {
        $fabricante = FabricanteService::update($request->all(), $fabricante);

        if ($fabricante) {
            flash('Fabricante atualizado com sucesso')->success();

            return back();
        }

        flash('Erro ao atualizar o fabricante')->error();

        return back()->withInput();
    }

    public function destroy(Fabricante $fabricante)
    {
        try {
            $fabricante->delete();
        } catch (Throwable $th) {
            return response('Erro ao apagar', 400);
        }
    }
}
