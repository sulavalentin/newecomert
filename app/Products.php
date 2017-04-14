<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Specifications;
use Carbon\Carbon;

class Products extends Model
{
    public function getHomePopulars(){
       return DB::table("products")
                ->select('products.*', 'images.address','favorite.id as idfavorite')
                ->leftJoin("images",function($join){
                    $join->on('products.id', '=', 'images.product_id');
                    $join->where('images.default','1');
                })
                ->leftJoin("favorite",function($join){
                    $join->on('products.id', '=', 'favorite.product_id');
                    $join->where('favorite.user_id',session('id'));
                })
                ->orderBy("products.views","desc")
                ->take(10)
                ->get();
    }
    public function getHomeNewProducts(){
       return DB::table("products")
                ->select('products.*', 'images.address','favorite.id as idfavorite')
                ->leftJoin("images",function($join){
                    $join->on('products.id', '=', 'images.product_id');
                    $join->where('images.default','1');
                })
                ->leftJoin("favorite",function($join){
                    $join->on('products.id', '=', 'favorite.product_id');
                    $join->where('favorite.user_id',session('id'));
                })
                ->orderBy("products.id","desc")
                ->take(10)
                ->get();
    }
    public function getAllItems(){
        $items=DB::table('itemsSubMenu')
                    ->select('itemsSubMenu.*','submenu.submenu_name','submenu.submenu_image','submenu.menu_id','menu.menu_name')
                    ->leftJoin("submenu",function($join){
                         $join->on('submenu.id', '=', 'itemsSubMenu.submenu_id');
                    })
                    ->leftJoin("menu",function($join){
                         $join->on('submenu.menu_id', '=', 'menu.id');
                    })
                    ->get();
        $aseaza=[];
        foreach($items as $key => $item)
        {
           $aseaza[$item->menu_name][$item->submenu_name][$key] = $item;
        } 
        return $aseaza;
    }

    
    public function getOneAdd($table){
        $coloane=DB::table('specificationgroup')
                ->select('specificationgroup.name_group','specificationname.*')
                ->leftJoin("specificationname",function($join){
                     $join->on('specificationgroup.id', '=', 'specificationname.group_id');
                })
                ->where('specificationname.table_id',$table)
                ->get();
        $arr[0]=["Id",""];
        $arr[1]=["Nume",""];
        $arr[2]=["Pret",""];
        $aseaza=[];
        foreach($coloane as $key => $item)
        {
           $aseaza[$item->name_group][$key] = $item;
        }
        $arr[3]=$aseaza;
        $images=[];
        $arr[4]=[asset(""),$images];
        return $arr;
    }
    public function getOneItem($id,$table){
        $c=DB::table("products")
                ->where("id",$id)
                ->get();
        $coloane=DB::table('specificationgroup')
                ->select('specificationgroup.name_group','specificationname.*')
                ->leftJoin("specificationname",function($join){
                     $join->on('specificationgroup.id', '=', 'specificationname.group_id');
                })
                ->where('specificationname.table_id',$table)
                ->get();
        $valori=DB::table('specifications')
                ->where('product_id',$id)
                ->get();
        $arr[0]=["Id",$c[0]->id];
        $arr[1]=["Nume",$c[0]->originalname];
        $arr[2]=["Pret",$c[0]->price];
        $aseaza=[];
        foreach($coloane as $key => $item)
        {
           $aseaza[$item->name_group][$key] = $item;
        }
        $arr[3]=$aseaza;
        $arr[4]=$valori;
        $k=5;
        $images=DB::table("images")
                ->where("product_id",$id)
                ->get();
        $arr[$k]=[asset(""),$images];
        return $arr;
    }
    public function getDescriptionsProduct($id){
        $return=DB::table("descriere")->where("product_id",$id)->get();
        $product=DB::table("products")->where("id",$id)->first();
        return ["id"=>$id,
                "description"=>$return,
                "product"=>$product
                ];
    }
    public function addItem($request,$tabela){
        $originalname=$request->rowvalue[0];
        $name=$request->name;
        $id=DB::table("products")->insertGetId(["table_id"=>$tabela,
                                      "originalname"=>ucwords($originalname),
                                      "name"=>ucwords($name),
                                      "price"=>$request->rowvalue[1],
                                      "created_at"=>Carbon::now()]);
        for($i=2;$i<sizeof($request->rowvalue);$i++){
            DB::table("specifications")->insert(["product_id"=>$id,
                                                "specification_id"=>$request->rowid[$i],
                                                "value"=>$request->rowvalue[$i]]);
        } 
        DB::table("images")
                ->where("product_id",-1)
                ->update(["product_id"=>$id]);
    }
    public function modificaItem($request,$tabela,$id){
        $originalname=$request->rowvalue[0];
        $name=$request->name;
        DB::table("products")->where("id",$id)->update(["originalname"=>ucwords($originalname),
                                                        "name"=>ucwords($name),
                                                        "price"=>$request->rowvalue[1]]);
        for($i=2;$i<sizeof($request->rowvalue);$i++){
            if(strlen($request->rowvalue[$i])>0){
                $spec=Specifications::firstOrNew(array("product_id"=>$id,"specification_id"=>$request->rowid[$i]));
                $spec->product_id=$id;
                $spec->specification_id=$request->rowid[$i];
                $spec->value=$request->rowvalue[$i];
                $spec->timestamps = false;
                $spec->save();
            }else{
                DB::table("specifications")
                        ->where("product_id",$id)
                        ->where("specification_id",$request->rowid[$i])
                        ->delete();
            }
        }
    }
    public function deleteItem($id){
        DB::table("products")->where('id', $id)->delete();
        DB::table("specifications")->where('product_id', $id)->delete();
    }
}
