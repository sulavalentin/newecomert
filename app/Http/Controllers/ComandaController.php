<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Cookie;
use Carbon\Carbon;
use Session;

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
    public function endcomanda(Request $request){
        if( Cookie::get('cart')!==null ){
            $anonim=Cookie::get('cart');
            $nume=$request->nume;
            $email=$request->email;
            $telefon=$request->telefon;
            $adresa=$request->adresa;
            $data=Carbon::now(3);
            $produse=DB::table('products')
                    ->select('products.*','cart.cantitate')
                    ->leftJoin("cart",function($join){
                        $join->on('cart.product_id', '=', 'products.id');
                    })
                    ->where('cart.anonim',$anonim)
                    ->orderBy("cart.id","desc")
                    ->distinct()
                    ->get();
            $id=DB::table("comenzi")->insertGetId([
                    "nume"=>$nume,
                    "email"=>$email,
                    "telefon"=>$telefon,
                    "adresa"=>$adresa,
                    "created_at"=>$data
                ]);
            foreach($produse as $i){
                DB::table("marfuricomenzi")->insert([
                    "id_comenzi"=>$id,
                    "id_produs"=>$i->id,
                    "originalnameprodus"=>$i->originalname,
                    "nameprodus"=>$i->name,
                    "priceprodus"=>$i->price,
                    "cantitateprodus"=>$i->cantitate
                ]);
            }
            DB::table("cart")->where("anonim",$anonim)->delete();
            session::put("comandatrimisa",1); 
        }
    }
    public function comandatrimisa(){
        if(session('comandatrimisa')==1){
            session()->forget('comandatrimisa');
            return view("tanks.comandatrimisa");
        }else{
            return redirect('/');
        }
        
    }
}
