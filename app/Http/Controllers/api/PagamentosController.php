<?php

namespace App\Http\Controllers\api;

use App\Models\Pagamentos;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PagamentosRequest;

class PagamentosController extends Controller
{
    public function store(PagamentosRequest $request){
        if( $pagamento = Pagamentos::create($request->all()) ){
            $resposta = [
                    'pagamentos_id'   => $pagamento->id,
                    'status'  => 'CADASTRADO'
            ];
            return response()->json($resposta,201);
        } else {
            $resposta = [
                'pagamentos_id'   => 0,
                'status'  => 'NAO CADASTRADO'
            ];
        return response()->json($resposta,400);
        }

    }

    public function index(){
     return ['STATUS','OK4'];
    }
}
