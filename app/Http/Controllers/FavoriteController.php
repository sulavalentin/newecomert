<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Favorite;

class FavoriteController extends Controller
{
    public function favorite(){
        $favorite=DB::table("favorite")->where("id",session("id"))->get();
        return view("favorite",["favorite"=>$favorite]);
    }
}
