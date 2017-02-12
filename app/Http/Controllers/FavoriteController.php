<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Favorite;
use Carbon\Carbon;

class FavoriteController extends Controller
{
    public function favorite(){
        $favorite=DB::table("favorite")->where("id",session("id"))->get();
        return view("favorite",["favorite"=>$favorite]);
    }
    public function addfavorite(Request $request){
        $id=$request->id;
        if(session("id")>0){
            $exist=DB::table("favorite")->where("user_id",session("id"))->where("product_id",$id)->first();
            if(is_null($exist)){
                $time=Carbon::now();
                DB::table("favorite")->insert(["user_id"=>session("id"),"product_id"=>$id,"created_at"=>$time]);
                $return[0]=DB::table("favorite")->where("user_id",session("id"))->count("id");
                $return[1]=DB::table("products")
                                ->leftJoin("images",function($join){
                                    $join->on('products.id', '=', 'images.product_id');
                                    $join->where('images.default','1');
                                })
                                ->first();
                return response()->json($return);
            }else{
                DB::table("favorite")->where("user_id",session("id"))->where("product_id",$id)->delete();
                return response()->json(0);
            }
            
        }else{
            return response()->json(false);
        }
    }
    public function getCountFavorite()
    {
        $response=DB::table("favorite")->where("user_id",session("id"))->count("id");
        return $response;
    }
}
