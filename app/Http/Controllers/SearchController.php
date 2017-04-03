<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Search;

class SearchController extends Controller
{
    public function search(Request $request){
        $search=$request->search;
        $result=Search::getSearch($search);
        return view("search",["post"=>$result]);
    }
}
