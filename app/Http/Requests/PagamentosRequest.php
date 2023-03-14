<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PagamentosRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'valor_pagamento'               => ['required','min:1'],
            'nome_cartao'                   => ['required'],
            'numero_cartao'                 => ['required','min:16','max:16'],
            'validade'                      => ['required','date_format:Y/m'],
            'cvv'                           => ['required','min:3','max:3'],
        ];
    }

    public function messages()
    {
        return [
            'valor_pagamento.min'           => 'O valor do pagamento deve ser maior do que zero',
            'nome_cartao.required'          => 'O campo nome do cartão é obrigatório',
            'numero_cartao.required'        => 'O campo número do cartão é obrigatório',
            'numero_cartao.min'             => 'O campo número do cartão deve ter exatamente :min caracteres',
            'validade.required'             => 'O campo validade é obrigatório',
            'validade.date_format'          => 'O campo validade deve esta no formato YYYY/MM',
            'cvv.min'                       => 'O campo CVV deve ter exatamente :min caracteres',
        ];
    }
}