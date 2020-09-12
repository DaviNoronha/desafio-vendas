<?php

namespace App\Services;

use App\Models\Cliente;
use Illuminate\Support\Facades\Log;
use Throwable;

class ClienteService {
    
    public static function store($request)
    {
        try {
            return Cliente::create($request);
        } catch (Throwable $th) {
            Log::error($th->getMessage());
            return null;
        }
    }

    public static function update($request, $cliente)
    {
        try {
            return $cliente->update($request);
        } catch (Throwable $th) {
            Log::error($th->getMessage());
            return null;
        }
    }
}