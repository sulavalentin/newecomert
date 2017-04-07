<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class ComenziAdminController extends Controller
{
    
    public function comenziadmin(){
        if (!filter_var(session("emailAdmin"), FILTER_VALIDATE_EMAIL)){
            return redirect("/admin");
        }
        $return=DB::table('comenzi')
                ->select('comenzi.*', 'marfuricomenzi.*','images.address')
                ->leftJoin("marfuricomenzi",function($join){
                    $join->on('comenzi.id', '=', 'marfuricomenzi.id_comenzi');
                })
                ->leftJoin("images",function($join){
                    $join->on('marfuricomenzi.id_produs', '=', 'images.product_id');
                    $join->where('images.default','1');
                })
                ->where('comenzi.trecut',0)
                ->orderby('comenzi.id','desc')
                ->get();
        $arr=[];
        foreach($return as $i){
            $arr[$i->id]["nume"]=[
                "id"=>$i->id,
                "data"=>$i->created_at,
                "nume"=>$i->nume,
                "email"=>$i->email,
                "telefon"=>$i->telefon,
                "adresa"=>$i->adresa
            ];
            $arr[$i->id]["produse"][$i->idmarfuri]=[
                "imagine"=>$i->address,
                "originalname"=>$i->originalnameprodus,
                "name"=>$i->nameprodus,
                "price"=>$i->priceprodus,
                "cantitate"=>$i->cantitateprodus,
                "idprodus"=>$i->id_produs,
                "total"=>$i->cantitateprodus*$i->priceprodus
            ];
        }
        return view("admin.comenzi",["comenzi"=>$arr]);
    }
    public function allcomenziadmin(){
        if (!filter_var(session("emailAdmin"), FILTER_VALIDATE_EMAIL)){
            return redirect("/admin");
        }
        $return=DB::table('comenzi')
                ->select('comenzi.*', 'marfuricomenzi.*','images.address')
                ->leftJoin("marfuricomenzi",function($join){
                    $join->on('comenzi.id', '=', 'marfuricomenzi.id_comenzi');
                })
                ->leftJoin("images",function($join){
                    $join->on('marfuricomenzi.id_produs', '=', 'images.product_id');
                    $join->where('images.default','1');
                })
                ->orderby('comenzi.id','desc')
                ->get();
        $arr=[];
        foreach($return as $i){
            $arr[$i->id]["nume"]=[
                "id"=>$i->id,
                "data"=>$i->created_at,
                "nume"=>$i->nume,
                "email"=>$i->email,
                "telefon"=>$i->telefon,
                "adresa"=>$i->adresa
            ];
            $arr[$i->id]["produse"][$i->idmarfuri]=[
                "imagine"=>$i->address,
                "originalname"=>$i->originalnameprodus,
                "name"=>$i->nameprodus,
                "price"=>$i->priceprodus,
                "cantitate"=>$i->cantitateprodus,
                "idprodus"=>$i->id_produs,
                "total"=>$i->cantitateprodus*$i->priceprodus
            ];
        }
        return view("admin.allcomenzi",["comenzi"=>$arr]);
    }
    public function movecomanda(Request $request){
        if (!filter_var(session("emailAdmin"), FILTER_VALIDATE_EMAIL)){
            return redirect("/admin");
        }
        DB::table("comenzi")->where("id",$request->id)->update(["trecut"=>1]);
    }
}
