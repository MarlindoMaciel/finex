<?php

namespace App\Http\Controllers\api;

use App\Models\Pagamentos;
use App\Models\NotaFiscal;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PagamentosRequest;
use Illuminate\Support\Facades\Auth;
use DB;

class PagamentosController extends Controller
{
    public function store(PagamentosRequest $request){
        $pagamento = new Pagamentos(array_merge($request->validated(),['users_id'=>Auth::user()->id]));
        if(  $pagamento->save() ){
            $resposta = [
                            "id"        => "$pagamento->id",
                            "status"    => "CADASTRADO",
                            "message"   => "PAGAMENTO CADASTRADO",
                        ];
            $codigo = 201;
        } else {
            $resposta = [
                            "id"        => "0",
                            "status"    => "NÃO CADASTRADO",
                            "message"   => "PAGAMENTO NÃO PODE SER CADASTRADO",
                        ];
            $codigo = 202;
        }
        return response()->json($resposta,$codigo);
    }

    public function index($id){

        if( $pagamento = Pagamentos::whereId($id)
                                        ->where('users_id','=',Auth::user()->id)
                                        ->first() ){
            if( $pagamento->status === "CONFIRMADO" ){      
                $notafiscal = NotaFiscal::where('pagamentos_id','=',$pagamento->id)
                                          ->first();                          
                $resposta = [
                                "id"            => "$id",
                                "status"        => "$pagamento->status",
                                "id_notafiscal" => "$notafiscal->id",
                                "nome"          => "$notafiscal->nome",
                                "email"         => "$notafiscal->email",
                                "cpf"           => "$notafiscal->cpf",
                                "telefone"      => "$notafiscal->telefone",
                                "rua"           => "$notafiscal->rua",
                                "numero"        => "$notafiscal->numero",
                                "bairro"        => "$notafiscal->bairro",
                                "cidade"        => "$notafiscal->cidade",
                                "estado"        => "$notafiscal->estado",
                                "message"       => "PAGAMENTO CONFIRMADO",
                            ];
                $codigo = 200;
            } else {
                $resposta = [
                                "id"        => "$id",
                                "status"    => "$pagamento->status",
                                "message"   => "PAGAMENTO NÃO CONFIRMADO",
                ];
                $codigo = 201;
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

    public function cancel($id){       
        if( $pagamento = Pagamentos::whereId($id)
                                        ->where('users_id','=',Auth::user()->id)
                                        ->first() ){
            if( $pagamento->status === "CADASTRADO" ){
                $pagamento->status = "CANCELADO";
                $pagamento->save();
                $resposta = [
                                "id"        => "$id",
                                "status"    => "$pagamento->status",
                                "message"   => "PAGAMENTO CANCELADO",
                            ];
                $codigo = 204;            
            } else {
                $resposta = [
                                "id"        => "$id",
                                "status"    => "$pagamento->status",
                                "message"   => "PAGAMENTO NÃO PODE SER CANCELADO",
                            ];
                $codigo = 203;   
            }             
        } else {
            $resposta = [
                            "id"        => "$id",
                            "status"    => "NÃO CADASTRADO",
                            "message"   => "PAGAMENTO NAO ENCONTRADO",
                        ];
            $codigo = 202;            
        }
        return response()->json($resposta,$codigo);
    }

    public function confirm(Request $request, $id){
        DB::beginTransaction();

        if( $pagamento = Pagamentos::whereId($id)
                                        ->where('users_id','=',Auth::user()->id)
                                        ->first() ){
            if( $pagamento->status === 'CADASTRADO' ){
                $pagamento->status = "CONFIRMADO";
                if( $pagamento->save() ){

                    $notafiscal = new NotaFiscal( $request->all() );

                    if( $notafiscal->save() ){
                        DB::commit();
                        $resposta = [
                                        "id"        => "$id",
                                        "status"    => "$pagamento->status",
                                        "message"    => "PAGAMENTO CONFIRMADO",
                                    ];
                        $codigo = 200;
                    } else {
                        DB::rollBack();
                        $resposta = [
                                        "id"        => "$id",
                                        "status"    => "$pagamento->status",
                                        "message"   => "PAGAMENTO NÃO PODE SER CONFIRMADO",
                                    ];
                        $codigo = 401;            
                    }
                }        
            } elseif( $pagamento->status === 'CONFIRMADO' ){
                DB::rollBack();
                $resposta = [
                                "id"        => "$id",
                                "status"    => "$pagamento->status",
                                "message"   => "PAGAMENTO JÁ ESTÁ CONFIRMADO",
                            ];
                $codigo = 202;            
            }
        } else {
            $resposta = [
                            "id"        => "$id",
                            "status"    => "NAO CADASTRADO",
                            "message"   => "PAGAMENTO NAO ENCONTRADO",
                        ];
            $codigo = 202;            
        }
        return response()->json($resposta,$codigo);
    }

    public function list(){
        $pagamentos = Pagamentos::where('users_id','=',Auth::user()->id)
                                    ->get(['id','valor_pagamento','created_at','status']);
        if( count($pagamentos) === 0 ){
            $resposta = [
                "message"    => "NENHUM PAGAMENTO ENCONTRADO",
            ];
            $codigo = 202;            
        } else {
            $resposta = array_merge(["QUANTIDADE DE PAGAMENTOS"=>count($pagamentos)],$pagamentos->toArray());
            $codigo = 200;            
        }    
        
        return response()->json($resposta,$codigo);
    }    
}
