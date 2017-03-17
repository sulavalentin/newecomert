<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Compare extends Model
{
    public function getCompare(){
        return DB::table('products')
                ->select('products.*', 'images.address')
                ->leftJoin("images",function($join){
                            $join->on('products.id', '=', 'images.product_id');
                            $join->where('images.default','1');
                        })
                ->whereIn('products.id',session("idcompare"))
                ->get();
    }
    public function getSpecificationsname(){
        $return=DB::table('specifications')
                ->select('specifications.*','specificationname.*','specificationgroup.*')
                ->leftJoin("specificationname",function($join){
                     $join->on('specifications.specification_id', '=', 'specificationname.id');
                })
                ->leftJoin("specificationgroup",function($join){
                    $join->on('specificationname.group_id', '=', 'specificationgroup.id');
                })
                ->whereIn('specifications.product_id',session("idcompare"))
                ->get();
        $arr=[];
        foreach($return as $key => $item)
        {
            if($item->value!=null){
                $arr[$item->name_group][$item->specification_name][$key] = $item;
            }
        }
        return $arr;
    }
}
