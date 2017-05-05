<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Cart;
use App\Itemssubmenu;
use Cookie;
use Carbon\Carbon;

class CartController extends Controller
{
    public function cart(){
        $val=-100;
        if( Cookie::get('cart')!==null ){
            $val=Cookie::get('cart');
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
            $total=DB::table('cart')
                    ->select(DB::raw('sum(products.price*cart.cantitate) AS totalprice'))
                    ->leftJoin("products",function($join){
                        $join->on('cart.product_id', '=', 'products.id');
                    })
                    ->where("anonim",$val)
                    ->first();
            return view("cart",["products"=>$response,"total"=>$total]);
        }
        return view("cart");
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
            DB::table("cart")->where("anonim",$anonim)->update(["created_at"=>Carbon::now()]);
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
            $total=DB::table('cart')
                ->select(DB::raw('sum(products.price*cart.cantitate) AS totalprice'))
                ->leftJoin("products",function($join){
                    $join->on('cart.product_id', '=', 'products.id');
                })
                ->where("anonim",$anonim)
                ->first();
                if($total->totalprice>0){
                    $return[1] = number_format($total->totalprice, 2, '.', ' ');
                }else{
                    $return[1] = 0;
                } 
        
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
            $date = Carbon::now(3);
            $date->modify('-14 day');
            $formatted_date = $date->format('Y-m-d H:i:s');
            DB::table('cart')->where('created_at','<=',$formatted_date)->delete();
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
                return  0;
            }
        }
    }
    public function deleteallcart(){
        $anonim=Cookie::get('cart');
        DB::table("cart")->where("anonim",$anonim)->delete();
    }
}
