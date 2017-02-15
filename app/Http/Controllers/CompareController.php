<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class CompareController extends Controller
{
    public function compare(){
        $return=DB::table("products")->whereIn("id",session("idcompare"))->get();
        return view("compare",["compare"=>$return]);
    }
    public function addcompare(Request $request){
        $id=$request->id;
        if (empty(session("idcompare"))) {
            session(["idcompare"=>array()]);
        }
        $session=session("idcompare");
        
        if(count($session) <4){
            if(in_array($id,$session)){
                return response()->json(1);
            }
            if(count($session)>0){
                $lafel=DB::table("products")->where("id",session("idcompare")[0])->value("table_id");
                $curent=DB::table("products")->where("id",$id)->value("table_id");
                if($lafel!=$curent){
                    return response()->json(2);
                }
            }
            
            
            $session[]=$id;
            session(["idcompare"=>$session]);
            return response()->json(true);
        }else{
            return response()->json(false);
        }  
    }
}
