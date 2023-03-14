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
            'valor_pagamento'  => ['required','min:1'],
            'nome_cartao'      => ['required'],
            'numero_cartao'    => ['required','min:16','max:16'],
            'codigo_cvv'       => ['required','min:3','max:3'],
            'data_expiracao'   => ['required','date_format:Y/m'],
        ];
    }

    public function messages()
    {
        return [
            'valor_pagamento.min'         => 'O valor do pagamento deve ser maior do que zero',
            'nome_cartao.required'        => 'O campo nome do cartão é obrigatório',
            'numero_cartao.required'      => 'O campo número do cartão é obrigatório',
            'numero_cartao.min'           => 'O campo número do cartão deve ter exatamente :min caracteres',
            'codigo_cvv.min'              => 'O campo CVV deve ter exatamente :min caracteres',
            'data_expiracao.required'     => 'O campo data de expiração é obrigatório',
            'data_expiracao.date_format'  => 'O campo data de expiração deve esta no formato YYYY/MM',
        ];
    }
}