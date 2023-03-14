<?php

namespace App\Http\Controllers\api;

use App\Models\Pagamentos;
use App\Models\NotaFiscal;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PagamentosRequest;
use DB;

class PagamentosController extends Controller
{
    public function store(PagamentosRequest $request){

        $pagamento = new Pagamentos($request->validated());
        if(  $pagamento->save() ){
            $resposta = [
                            "id"        => "$pagamento->id",
                            "status"    => "PAGAMENTO CADASTRADO",
                        ];
            $codigo = 201;
        } else {
            $resposta = [
                            "id"        => "0",
                            "status"    => "PAGAMENTO NÃO CADASTRADO",
                        ];
            $codigo = 202;
        }
        return response()->json($resposta,$codigo);
    }

    public function index($id){

        if( $pagamento = Pagamentos::find($id) ){
            $resposta = [
                            "id"        => "$id",
                            "status"    => "$pagamento->status",
                        ];
            $codigo = 201;
        } else {
            $resposta = [
                            "id"        => "$id",
                            "status"    => "PAGAMENTO NAO ENCONTRADO",
                        ];
            $codigo = 202;            
        }
        return response()->json($resposta,$codigo);
    }

    public function cancel($id){
        
        if( $pagamento = Pagamentos::find($id) ){
            $pagamento->status = "CANCELADO";
            $pagamento->save();
            $resposta = [
                            "id"        => "$id",
                            "status"    => "PAGAMENTO CANCELADO",
                        ];
            $codigo = 204;            
        } else {
            $resposta = [
                            "id"        => "$id",
                            "status"    => "PAGAMENTO NAO ENCONTRADO",
                        ];
            $codigo = 202;            
        }
        return response()->json($resposta,$codigo);
    }

    public function confirm(Request $request, $id){
        DB::beginTransaction();

        if( $pagamento = Pagamentos::find($id) ){    
            if( $pagamento->status === 'CADASTRADO' ){

                $pagamento->status = "CONFIRMADO";
                if( $pagamento->save() ){

                    $notafiscal = new NotaFiscal( $request->all() );

                    if( $notafiscal->save() ){
                        DB::commit();
                        $resposta = [
                                        "id"        => "$id",
                                        "status"    => "PAGAMENTO CONFIRMADO",
                                    ];
                        $codigo = 200;
                    } else {
                        DB::rollBack();
                        $resposta = [
                            "id"        => "$id",
                            "status"    => "FALHA NA CONFIRMAÇÃO DE PAGAMENTO",
                        ];
                        $codigo = 401;            
                    }    
                } else {
                    DB::rollBack();
                    $resposta = [
                        "id"        => "$id",
                        "status"    => "PAGAMENTO NÃO ENCONTRADO",
                    ];
                    $codigo = 202;            
                } 

            } else {
                DB::rollBack();
                $resposta = [
                    "id"        => "$id",
                    "status"    => "PAGAMENTO JÁ ESTÁ CONFIRMADO",
                ];
                $codigo = 202;            
            }
        } else {
            $resposta = [
                            "id"        => "$id",
                            "status"    => "PAGAMENTO NAO ENCONTRADO",
                        ];
            $codigo = 202;            
        }
        return response()->json($resposta,$codigo);
    }


}
