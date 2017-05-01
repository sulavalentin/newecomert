<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Search;
use App\Products;
use DB;

class SearchController extends Controller
{
    public function search(Request $request){
        $search=$request->search;
        $error="";
        if(strlen($search)>=1){
            $result=Search::getSearch($search);
            
        }else{
            $result=null;
            $error="error";
        }
        return view("search",
                    [
                        "post"=>$result,
                        "search"=>$search,
                        "error"=>$error
                    ]);
    }
    public function searchajax(Request $request){
        $search=$request->search;
        $words = explode(' ', $search);
        $result = Products::query();
        foreach ($words as $word) {
            $result = $result->where('originalname', 'like', '%'.$word.'%');
        }
        $result = $result->orderby("products.table_id")->take(10)->get();
        
        return response()->json($result);
    }
}
