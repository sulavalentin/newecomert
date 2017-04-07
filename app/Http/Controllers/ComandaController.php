<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Cookie;

class ComandaController extends Controller
{
    public function comanda(){
        $return;
        if( Cookie::get('cart')!==null ){
            $anonim=Cookie::get('cart');
            $return["count"]=DB::table('cart')
                    ->select(DB::raw('sum(cart.cantitate) AS count'))
                    ->where('cart.anonim',$anonim)
                    ->value("count");
            $return["produse"]=DB::table('products')
                    ->select('products.*','cart.cantitate',DB::raw('(products.price*cart.cantitate) AS total'))
                    ->leftJoin("cart",function($join){
                        $join->on('cart.product_id', '=', 'products.id');
                    })
                    ->where('cart.anonim',$anonim)
                    ->orderBy("cart.id","desc")
                    ->distinct()
                    ->get();
            $return["sumatotala"]=DB::table('cart')
                    ->select(DB::raw('sum(products.price*cart.cantitate) AS totalprice'))
                    ->leftJoin("products",function($join){
                        $join->on('cart.product_id', '=', 'products.id');
                    })
                    ->where("anonim",$anonim)
                    ->value("totalprice");
            if(session("id")>0){
                $return["profil"]=DB::table("users")
                        ->where("id",session("id"))
                        ->first();
            }
        }
        return view("comanda",["return"=>$return]);
    }
}
