<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "nome" => "required",
            "telefone" => "required",
            "email" => "required|email",
            "cpf" => "required"
        ];
    }
}
