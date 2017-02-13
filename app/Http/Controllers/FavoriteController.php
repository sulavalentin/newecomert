<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Favorite;
use Carbon\Carbon;

class FavoriteController extends Controller
{
    public function favorite(){
        $favorite=DB::table("favorite")
                ->select("products.*","images.address","favorite.created_at as created_at","favorite.id as favorite_id")
                ->leftJoin("products",function($join){
                    $join->on("products.id","=","favorite.product_id");
                })
                ->leftJoin("images",function($join){
                    $join->on('products.id', '=', 'images.product_id');
                    $join->where('images.default','1');
                })
                ->where("favorite.user_id",session("id"))
                ->get();
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
                                ->where("products.id",$id)
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
    public function deletefavorite(Request $request){
        DB::table("favorite")
                ->where("user_id",session("id"))
                ->where("id",$request->id)
                ->delete();
    }
    public function getCountFavorite()
    {
        $response=DB::table("favorite")->where("user_id",session("id"))->count("id");
        return $response;
    }
}
