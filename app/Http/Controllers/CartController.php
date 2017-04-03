<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Cart;
use App\ItemsSubMenu;
use Cookie;

class CartController extends Controller
{
    public function cart(){
        $val=-100;
        if( Cookie::get('cart')!==null ){
            $val=Cookie::get('cart');
        }
        $response=DB::table('products')
                            ->select('products.*', 'images.address','cart.cantitate',DB::raw('(products.price*cart.cantitate) AS total'))
                            ->leftJoin("images",function($join){
                                        $join->on('products.id', '=', 'images.product_id');
                                        $join->where('images.default','1');
                                    })
                            ->leftJoin("cart",function($join){
                                $join->on('cart.product_id', '=', 'products.id');
                            })
                            ->where('cart.anonim',$val)
                            ->orderBy("cart.id","desc")
                            ->distinct()
                            ->get();
        return view("cart",["products"=>$response]);
    }
    public function addcart(Request $request , Cart $cart , ItemsSubMenu $item)
    {   
        $id=$request->id; $time=60*24*14; /*60 * 24 * 14 = 14 drays 60=minutes 24=hours 14=days*/
        $value=0;
        $prod=$item->getItemForCart($id);
        if( Cookie::get('cart')!==null ){
            $anonim=Cookie::get('cart');
            $firstOrNew=DB::Table("cart")->where("anonim",$anonim)
                        ->where("product_id",$id)->first();
            if(!empty($firstOrNew)){
                DB::table("cart")
                        ->where("anonim",$anonim)->where("product_id",$id)
                        ->increment('cantitate');
            }else{
                DB::table("cart")->insert(["anonim"=>$anonim,"product_id"=>$id]);
            }
            $count=DB::table("cart")->where("anonim",$anonim)->sum("cantitate");
            return [$count,$prod];
        }else{
            $value=DB::table("cart")->max("anonim")+1;
            if(empty($value)){
                $value=0;
            }
            DB::table("cart")->insert(["anonim"=>$value,"product_id"=>$id]);
            $cookie = cookie('cart', $value, $time);
            return response([1,$prod])->cookie($cookie);
        }
        
    }
    public function updatecart(Request $request , Cart $cart)
    {   
        $id=$request->id;
        $cantitate=$request->cantitate;
        if( Cookie::get('cart')!==null ){
            $anonim=Cookie::get('cart');
            if(is_int((int)$cantitate) && $cantitate>=1){
               DB::table("cart")
                    ->where("anonim",$anonim)
                    ->where("product_id",$id)
                    ->update(["cantitate"=>$cantitate]); 
            }
            $return=DB::table("cart")
                       ->select("cart.cantitate",DB::raw('products.price*cart.cantitate AS totalone'))
                       ->leftJoin("products",function($join){
                                $join->on('cart.product_id', '=', 'products.id');
                            })
                       ->where("anonim",$anonim)
                       ->where("product_id",$id)
                       ->get();
            $return[0]->totalone=number_format($return[0]->totalone, 2, '.', ' ');
            return $return;
        }
    }
    public function delcart(Request $request , Cart $cart)
    {   
        $id=$request->id;
        if( Cookie::get('cart')!==null ){
            $anonim=Cookie::get('cart');
            DB::table("cart")
                    ->where("anonim",$anonim)
                    ->where("product_id",$id)
                    ->delete();
        }
    }
    public function totalprice(Request $request , Cart $cart)
    {   
        if( Cookie::get('cart')!==null ){
            $anonim=Cookie::get('cart');
            $total=DB::table('cart')
                ->select(DB::raw('sum(products.price*cart.cantitate) AS totalprice'))
                ->leftJoin("products",function($join){
                    $join->on('cart.product_id', '=', 'products.id');
                })
                ->where("anonim",$anonim)
                ->first();
                if($total->totalprice>0){
                    return number_format($total->totalprice, 2, '.', ' ');
                }else{
                    return 0;
                } 
        }
    }
    public function getCountCart()
    {
        $response=0;
        if( Cookie::get('cart')!==null ){
            $anonim=Cookie::get('cart');
            $response=DB::table("cart")->where("anonim",$anonim)->sum("cantitate");
        }
        return $response;
    }
    public function deleteallcart(){
        $anonim=Cookie::get('cart');
        DB::table("cart")->where("anonim",$anonim)->delete();
    }
}
