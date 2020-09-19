<?php

namespace App\Services;

use App\Models\Produto;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProdutoService
{
    public static function store($request)
    {
        try {
            return Produto::create($request);
        } catch (Throwable $th) {
            Log::error($th->getMessage());
            return null;
        }
    }

    public static function update($request, $produto)
    {
        try {
            return $produto->update($request);
        } catch (Throwable $th) {
            Log::error($th->getMessage());
            return null;
        }
    }
    
    public static function listaProdutos($request)
    {
        if (isset($request['searchTerm'])) {
            return Produto::select('id', 'descricao as text')
                        ->where('descricao', 'like', '%' . $request['searchTerm'] . '%')
                        ->limit(10)
                        ->get();
        }

        return Produto::select('id', 'descricao as text')
                    ->limit(10)
                    ->get();
    }
}