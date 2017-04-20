<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Search extends Model
{
    public static function getSearch($search){
        $return=DB::table('products')
                ->select('products.*', 'images.address','favorite.id as idfavorite')
                ->leftJoin("images",function($join){
                            $join->on('products.id', '=', 'images.product_id');
                            $join->where('images.default','1');
                        })
                ->leftJoin("favorite",function($join){
                    $join->on('products.id', '=', 'favorite.product_id');
                    $join->where('favorite.user_id',session('id'));
                })
                ->where('originalname', 'like', '%'.$search.'%')
                ->orWhere('name', 'like', '%'.$search.'%')
                ->orderby("products.table_id")
                ->paginate(8);
        $return->setPath("search?search=".$search);
        return $return;
    }
    public static function getSearchInMenu($search){
        $id=DB::Table("itemssubmenu")->where("item_name","like","%".$search."%")->pluck("id");
        $return=DB::table('products')
                ->select('products.*', 'images.address','favorite.id as idfavorite')
                ->leftJoin("images",function($join){
                            $join->on('products.id', '=', 'images.product_id');
                            $join->where('images.default','1');
                        })
                ->leftJoin("favorite",function($join){
                    $join->on('products.id', '=', 'favorite.product_id');
                    $join->where('favorite.user_id',session('id'));
                })
                ->whereIn('table_id', $id)
                ->orderby("products.table_id")
                ->paginate(8);
        $return->setPath("search?search=".$search);
        return $return;
    }
}
