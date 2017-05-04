<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Compare;

class CompareController extends Controller
{
    public function compare(Compare $compare){
        $return=$compare->getCompare();
        $specificationsname=$compare->getSpecificationsname();
        return view("compare",[
                "compare"=>$return,
                "specificationsname"=>$specificationsname["arr"],
                "cantitate"=>$specificationsname["session"],
            ]);
    }
    public function addcompare(Request $request){
        $id=$request->id;
        if (empty(session("idcompare"))) {
            session(["idcompare"=>array()]);
        }
        $session=session("idcompare");
        
        if(count($session) <4){
            if(in_array($id,$session)){
                $data=["truefalse"=>1,"countcompare"=>count(session("idcompare"))];
                return response()->json($data);
            }
            if(count($session)>0){
                $lafel=DB::table("products")->where("id",session("idcompare")[0])->value("table_id");
                $curent=DB::table("products")->where("id",$id)->value("table_id");
                if($lafel!=$curent){
                    $data=["truefalse"=>2,"countcompare"=>count(session("idcompare"))];
                    return response()->json($data);
                }
            }
            $session[]=$id;
            session(["idcompare"=>$session]);
            $data=["truefalse"=>true,"countcompare"=>count(session("idcompare"))];
            return response()->json($data);
        }else{
            $data=["truefalse"=>false,"countcompare"=>count(session("idcompare"))];
            return response()->json($data);
        }  
    }
    public function deletecompare(Request $request){
        $id=$request->id;
        $key = array_search($id, session("idcompare"));
        $values=session("idcompare");
        unset($values[$key]);
        session(["idcompare"=>$values]);
    }
}
