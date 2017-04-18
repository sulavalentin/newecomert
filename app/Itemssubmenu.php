<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Itemssubmenu extends Model
{
    public function getProducts($id,$pag,$ordon){
        $nrPePag=16;
        $key="";$value="";
        switch($ordon){
            case "priceUp":{$key="price"; $value="asc"; break;}
            case "priceDown":{$key="price"; $value="desc"; break;}
            case "nameUp":{$key="originalname"; $value="asc"; break;}
            case "nameDown":{$key="originalname"; $value="desc"; break;}
            case "created":{$key="created_at"; $value="asc"; break;}
            case "popular":{$key="views"; $value="desc"; break;}
            default:{$key="price"; $value="asc";}
        }
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
                ->where('table_id',$id)
                ->orderby($key,$value)
                ->skip(($pag-1)*$nrPePag)->take($nrPePag)->get(); 
        return $return;
    }
    public function getValorsWithParameters($input,$id_submenu){
        $id=0;$val=[];
        foreach($input as $key=>$value){
            $value=DB::table("specifications")->where("id",$value)->value("value");
            $val[]=DB::table("specifications")
                    ->where("specification_id",$key)
                    ->where("value",$value)
                    ->pluck("product_id");
        }
        $res=$val[0]->toArray();
        foreach($val as $key=>$value){
            $value=$value->toArray();
            $res=array_intersect($res,$value);
        }
        return $res;
    }
    public function getProductsWithParameters($input,$id_submenu,$pag,$ordon){
        $nrPePag=16;
        $res=ItemsSubMenu::getValorsWithParameters($input,$id_submenu);
        $key="";$value="";
        switch($ordon){
            case "priceUp":{$key="price"; $value="asc"; break;}
            case "priceDown":{$key="price"; $value="desc"; break;}
            case "nameUp":{$key="originalname"; $value="asc"; break;}
            case "nameDown":{$key="originalname"; $value="desc"; break;}
            case "created":{$key="created_at"; $value="desc"; break;}
            case "popular":{$key="views"; $value="desc"; break;}
            default:{$key="price"; $value="asc";}
        }
            return  DB::table('products')
                            ->select('products.*', 'images.address','favorite.id as idfavorite')
                            ->leftJoin("images",function($join){
                                        $join->on('products.id', '=', 'images.product_id');
                                        $join->where('images.default','1');
                                    })
                            ->leftJoin("favorite",function($join){
                                    $join->on('products.id', '=', 'favorite.product_id');
                                    $join->where('favorite.user_id',session('id'));
                                })
                            ->where('table_id',$id_submenu)
                            ->whereIn("products.id",$res)
                            ->orderby($key,$value)
                            ->skip(($pag-1)*$nrPePag)->take($nrPePag)->get();
    }
    public function getPaginare($id){
        $nrPePag=16;
        $total=DB::table('products')
                ->where('table_id',$id)
                ->count();
        if ($total%$nrPePag==0){
            $total=(int)($total/$nrPePag);
        }
        else{
            $total=(int)($total/$nrPePag)+1;
        }
        return $total;
    }
    public function getPaginareWithParameters($input,$id){
        $nrPePag=16;
        $total=count(ItemsSubMenu::getValorsWithParameters($input,$id));
        if ($total%$nrPePag==0){
            $total=(int)($total/$nrPePag);
        }
        else{
            $total=(int)($total/$nrPePag)+1;
        }
        return $total;
    }
    public function getSortare($id){
        $sort=DB::table("specificationname")
                ->distinct()
                ->select("specificationname.*","specifications.value",'specifications.id as idspec')
                ->leftJoin("specifications",function($join){
                        $join->on('specifications.specification_id', '=', 'specificationname.id');
                    })
                ->where("table_id",$id)
                ->where("addsearch",1)
                ->orderBy(DB::raw('LENGTH(value), value'))
                ->get();
        $arr=[];
        foreach($sort as $key => $item)
        {
            $arr[$item->specification_name][$item->value] = $item;
        }
        return ["noselected"=>$arr];
    }
    public function getSortareWithParameters($input,$id_submenu){
        $id=[];
        $noselected=[];
        $selected=[];
        $val=[];
        foreach($input as $key=>$value){
            $id[]=DB::table("specificationName")
                    ->where("id",$key)
                    ->where("table_id",$id_submenu)
                    ->where("addsearch",1)
                    ->value("id");
            $val[]=$value;
        }
        /*selecte where sort is  selected*/
        $sort=DB::table("specificationname")
                ->distinct()
                ->select("specificationname.*","specifications.value",'specifications.id as idspec')
                ->leftJoin("specifications",function($join){
                        $join->on('specifications.specification_id', '=', 'specificationname.id');
                    })
                ->whereIn("specificationname.id",$id)
                ->whereIn("specifications.id",$val)
                ->where("table_id",$id_submenu)
                ->where("addsearch",1)
                            
                ->orderBy(DB::raw('LENGTH(value), value'))
                ->get();
        foreach($sort as $key => $item)
        {
            $selected[$item->specification_name][$item->value] = $item;
        }
        /*selecte where sort is not selected*/
        $prod=ItemsSubMenu::getValorsWithParameters($input,$id_submenu);
        $sort=DB::table("specificationname")
                ->distinct()
                ->select("specificationname.*","specifications.value",'specifications.id as idspec')
                ->leftJoin("specifications",function($join){
                        $join->on('specifications.specification_id', '=', 'specificationname.id');
                    })
                ->whereNotIn("specificationname.id",$id)
                ->whereIn("specifications.product_id",$prod)
                ->where("table_id",$id_submenu)
                ->where("addsearch",1)
                ->groupBy('specifications.value')
                ->orderBy(DB::raw('LENGTH(value), value'))
                ->get();
        foreach($sort as $key => $item)
        { 
            $noselected[$item->specification_name][$item->value] = $item;
        }
        return ["selected"=>$selected,
                "noselected"=>$noselected];
    }
    public function getLink($id,$ordon){
        $spec_id=DB::table('itemssubmenu')
                    ->select("menu.menu_name","itemssubmenu.submenu_id","itemssubmenu.id","itemssubmenu.item_name","submenu.submenu_name","submenu.menu_id")
                    ->leftJoin("submenu",function($join){
                         $join->on('itemssubmenu.submenu_id', '=', 'submenu.id');
                    })
                    ->leftJoin("menu",function($join){
                         $join->on('submenu.menu_id', '=', 'menu.id');
                    })
                    ->where("itemssubmenu.id",$id)
                    ->first();
        if(!empty($spec_id)){
            return ["0"=>["address"=>$spec_id->menu_id,
                          "name"=>$spec_id->menu_name],
                    "1"=>["address"=>$spec_id->submenu_id,
                          "name"=>$spec_id->submenu_name],
                    "2"=>["address"=>$spec_id->id,
                          "name"=>$spec_id->item_name],
                    "sort"=>$ordon,];
        }else{
            return false;
        }
    }
    public function createUrl($input){
       return implode('&', array_map(
                        function ($v, $k) {
                            if(is_array($v)){
                                return $k.'[]='.implode('&'.$k.'[]=', $v);
                            }else{
                                return $k.'='.$v;
                            }
                        }, 
                        $input, 
                        array_keys($input)
                    ));
    }
    public function getDenumireItems($id){
        $name=DB::table("products")
                ->where("id",$id)
                ->value("table_id");
        $spec_id=DB::table('itemssubmenu')
                    ->select("menu.menu_name","itemssubmenu.submenu_id","itemssubmenu.id","itemssubmenu.item_name","submenu.submenu_name","submenu.menu_id")
                    ->leftJoin("submenu",function($join){
                         $join->on('itemssubmenu.submenu_id', '=', 'submenu.id');
                    })
                    ->leftJoin("menu",function($join){
                         $join->on('submenu.menu_id', '=', 'menu.id');
                    })
                    ->where("itemssubmenu.id",$name)
                    ->first();
        if(!empty($spec_id)){
            return ["0"=>["address"=>$spec_id->menu_id,
                          "name"=>$spec_id->menu_name],
                    "1"=>["address"=>$spec_id->submenu_id,
                          "name"=>$spec_id->submenu_name],
                    "2"=>["address"=>$spec_id->id,
                          "name"=>$spec_id->item_name]
                    ];
        }else{
            return false;
        }
    }  
    public function getItem($id_item){
        if(!isset($_COOKIE['views'])) {
            setcookie("views", $id_item, time()+60);
            DB::table("products")->where("id",$id_item)->increment('views');
        }else{
            if($_COOKIE['views']!=$id_item){
                setcookie("views", $id_item, time()+60);
                DB::table("products")->where("id",$id_item)->increment('views');
            }
        }
        $c=DB::table('products')
                ->select('products.*', 'images.address','favorite.id as idfavorite')
                ->leftJoin("images",function($join){
                    $join->on('products.id', '=', 'images.product_id');
                    $join->where('images.default','1');
                })
                ->leftJoin("favorite",function($join){
                    $join->on('products.id', '=', 'favorite.product_id');
                    $join->where('favorite.user_id',session('id'));
                })
                ->where('products.id',$id_item)
                ->get();
        $c[1]=DB::table('specifications')
                ->select('specifications.*','specificationname.*','specificationgroup.*')
                ->leftJoin("specificationname",function($join){
                     $join->on('specifications.specification_id', '=', 'specificationname.id');
                })
                ->leftJoin("specificationgroup",function($join){
                    $join->on('specificationname.group_id', '=', 'specificationgroup.id');
                })
                ->where('specifications.product_id',$id_item)
                ->get();
        $arr=[];
        foreach($c[1] as $key => $item)
        {
            if($item->value!=null){
                $arr[$item->name_group][$key] = $item;
            }
        }
        $c[1]=$arr;
        return $c;
    }
    public function getItemForCart($id){
       return DB::table('products')
                ->select('products.*', 'images.address')
                 ->leftJoin("images",function($join){
                     $join->on('products.id', '=', 'images.product_id');
                     $join->where('images.default','1');
                 })
                ->where('products.id',$id)
                ->first();
    }
    public function getImages($id){
       return DB::table('images')
                ->where("product_id",$id)
                ->get();
    }  
    public function getAsemanatoare($id){
        $val=DB::table('products')->where("id",$id)->value("table_id");
        return DB::table('products')
                ->select('products.*', 'images.address','favorite.id as idfavorite')
                ->leftJoin("images",function($join){
                            $join->on('products.id', '=', 'images.product_id');
                            $join->where('images.default','1');
                        })
                ->leftJoin("favorite",function($join){
                    $join->on('products.id', '=', 'favorite.product_id');
                    $join->where('favorite.user_id',session('id'));
                })
                ->where('table_id',$val)
                ->where("products.id","!=",$id)
                ->inRandomOrder()
                ->take(6)
                ->get();    
    }
    public function getDescription($id){
        return DB::table("descriere")->where("product_id",$id)->get();
    }
    public function getComentarii($id){
        return DB::table("coments")->where("product_id",$id)->orderby("id","desc")->get();
    }
}
