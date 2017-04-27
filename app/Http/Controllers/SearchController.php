<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Search;
use DB;

class SearchController extends Controller
{
    public function search(Request $request){
        $search=$request->search;
        $error="";
        if(strlen($search)>=2){
            $result=Search::getSearch($search);
            $result2=Search::getSearchInMenu($search);
            
        }else{
            $result="";
            $result2="";
            $error="error";
        }
        return view("search",
                    [
                        "post"=>$result,
                        "post2"=>$result2,
                        "search"=>$search,
                        "error"=>$error
                    ]);
    }
    public function searchajax(Request $request){
        $search=$request->search;
        $return=DB::table("products")
                ->where('originalname', 'like', '%'.$search.'%')
                ->orWhere('name', 'like', '%'.$search.'%')
                ->orderby("products.table_id")
                ->take(20)
                ->get();
        return response()->json($return);
    }
}
