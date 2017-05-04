<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Cookie;
use Session;

class Cart extends Model
{
    public static function getCountCart()
    {
        $response=0;
        if( Cookie::get('cart')!==null ){
            $anonim=Cookie::get('cart');
            $response=DB::table("cart")->where("anonim",$anonim)->sum("cantitate");
        }
        return $response;
    }
}
