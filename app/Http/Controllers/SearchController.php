<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Search;

class SearchController extends Controller
{
    public function search(Request $request){
        $search=$request->search;
        $error="";
        if(strlen($search)>=3){
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
}
