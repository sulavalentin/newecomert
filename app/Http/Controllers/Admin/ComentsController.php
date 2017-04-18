<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class ComentsController extends Controller
{
    public function coments(){
        if (!filter_var(session("emailAdmin"), FILTER_VALIDATE_EMAIL)){
            return redirect("/admin");
        }
        $post=DB::table("products")
                ->select('products.*','coments.*','coments.id as idcom', 'images.address')
                ->leftJoin("images",function($join){
                    $join->on('products.id', '=', 'images.product_id');
                    $join->where('images.default','1');
                })
                ->Join("coments",function($join){
                    $join->on('products.id', '=', 'coments.product_id');
                })
                ->orderBy("coments.id","desc")
                ->paginate(20);
        return view("admin.coments",["post"=>$post]);
    }
    public function deletecoment(Request $request){
       if (!filter_var(session("emailAdmin"), FILTER_VALIDATE_EMAIL)){
            return redirect("/admin");
        }
        DB::table("coments")->where("id",$request->id)->delete();
    }
}
