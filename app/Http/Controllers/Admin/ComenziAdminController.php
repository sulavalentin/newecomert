<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
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
                "adresa"=>$i->adresa,
                "new"=>$i->new
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
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $col = new Collection($arr);
        $perPage = 10;
        $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $return = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage);
        $return->setPath(URL('/admin/comenzi'));
        $vazut=[];
        foreach($return as $i){
            $vazut[]=$i["nume"]["id"];
        }
        DB::table("comenzi")->whereIn("id",$vazut)->update(["new"=>0]);
        return view("admin.comenzi",["comenzi"=>$return]);
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
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $col = new Collection($arr);
        $perPage = 10;
        $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $return = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage);
        $return->setPath(URL('/admin/allcomenzi'));
        
        return view("admin.allcomenzi",["comenzi"=>$return]);
    }
    public function movecomanda(Request $request){
        if (!filter_var(session("emailAdmin"), FILTER_VALIDATE_EMAIL)){
            return redirect("/admin");
        }
        DB::table("comenzi")->where("id",$request->id)->update(["trecut"=>1]);
    }
}
