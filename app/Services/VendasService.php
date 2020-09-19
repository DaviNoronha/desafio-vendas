<?php

namespace App\Services;

use App\Models\Produto;
use App\Models\Venda;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class VendaService
{
    public static function store($request)
    {
        try {
            DB::beginTransaction();
            $venda = Venda::create([
                'forma_pagamento' => $request->forma_pagamento,
                'cliente_id' => $request->cliente_id,
                'observacao' => $request->observacao,
                'desconto' => 0,
                'acrescimo' => 0,
                'total' => 0,
            ]);

            $totalGeral = 0;

            foreach ( $request->produto_id as $indice => $valor ) {
                $produto = Produto::findOrFail($valor);
                $quantidade = $request->quantidade[$indice];

                $totalItem = $produto->preco * $quantidade;
                $totalGeral += $totalItem;

                $venda->itensVenda()->create([
                    'produto_id' => $produto->id,
                    'quantidade' => $quantidade,
                    'valor_unitario' => $produto->preco,
                    'valor_total' => $totalItem
                ]);
            }

            $desconto = 0;
            $acrescimo = 0;

            if ($request->forma_pagamento == Venda::DINHEIRO) {
                $desconto = 5 / 100 * $totalGeral;
                $totalGeral -= $desconto;
            } elseif ($request->forma_pagamento == Venda::CARTAO) {
                $acrescimo = 10 / 100 * $totalGeral;
                $totalGeral += $acrescimo;
            }

            $venda->update([
                'total' => $totalGeral,
                'desconto' => $desconto,
                'acrescimo' => $acrescimo,
            ]);

            DB::commit();
            return $venda;
        } catch (Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return null;
        }
    }
}