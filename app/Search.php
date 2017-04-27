<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Search extends Model
{
    public static function getSearch($search){
        $words = explode(' ', $search);
        $result = Products::query();
        $result = $result->select('products.*', 'images.address','favorite.id as idfavorite')
                    ->leftJoin("images",function($join){
                                $join->on('products.id', '=', 'images.product_id');
                                $join->where('images.default','1');
                            })
                    ->leftJoin("favorite",function($join){
                        $join->on('products.id', '=', 'favorite.product_id');
                        $join->where('favorite.user_id',session('id'));
                    });
        foreach ($words as $word) {
            $result = $result->where('originalname', 'like', '%'.$word.'%');
        }
        $result = $result->orderby("products.table_id")->paginate(8);
        $result->setPath("search?search=".$search);
        return $result;
    }
}
