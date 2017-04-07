<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class ComenziAdminController extends Controller
{
    public function comenziadmin($page){
        if (!filter_var(session("emailAdmin"), FILTER_VALIDATE_EMAIL)){
            return redirect("/admin");
        }
        $return=DB::table('comenzi')
                ->select('comenzi.*', 'marfuricomenzi.*')
                ->leftJoin("marfuricomenzi",function($join){
                            $join->on('comenzi.id', '=', 'marfuricomenzi.id_comenzi');
                        })
                ->orderby('comenzi.id','desc')
                ->take(20)
                ->get();
        $arr=[];
        dd($return);
        foreach($return as $i){
            
        }
        return view("admin.comenzi",["comenzi"=>$return]);
    }
}
