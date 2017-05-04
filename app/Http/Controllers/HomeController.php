<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Itemssubmenu;
use App\Products;
use App\Slideshow;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function home(Products $products,  Slideshow $slideshow)
    {
        return view('home',["slideshow"=>$slideshow->getSlideshow(),
                            "newproducts"=>$products->getHomeNewProducts(),
                            "populars"=>$products->getHomePopulars()
                            ]);
    }
    public function produse(Request $request,Itemssubmenu $item,$ordon, $id_submenu , $den , $pag )
    {
        $input = $request->all();
        if(count($input)>=1){
            return view("produse",["produse"=>$item->getProductsWithParameters($input,$id_submenu,$pag, $ordon),
                               "link"=>$item->getLink($id_submenu,$ordon),
                               "sortare"=>$item->getSortareWithParameters($input,$id_submenu),
                               "paginare"=>$item->getPaginareWithParameters($input,$id_submenu),
                               "curentpage"=>$pag,
                               "url"=>$item->createUrl($input)]);
        }else{
            return view("produse",["produse"=>$item->getProducts($id_submenu , $pag , $ordon),
                               "link"=>$item->getLink($id_submenu,$ordon),
                               "sortare"=>$item->getSortare($id_submenu),
                               "paginare"=>$item->getPaginare($id_submenu),
                               "curentpage"=>$pag,
                               "url"=>""]);
        }
    }
    public function oneprodus(Itemssubmenu $item , $id_item)
    {
        return view("article",["item"=>$item->getItem($id_item),
                               "link"=>$item->getDenumireItems($id_item),
                               "images"=>$item->getImages($id_item),
                               "asemanatoare"=>$item->getAsemanatoare($id_item),
                               "descriere"=>$item->getDescription($id_item),
                               "comentarii"=>$item->getComentarii($id_item)
                ]);
    }
    public function oneproduspreview(Request $request , Itemssubmenu $item)
    {
        $id_item=$request->id;
        $getitem=$item->getItem($id_item);
        $getitem["price"]=[
            "lei"=>number_format(floor($getitem[0]->price), 0, '.', ' '),
            "capici"=>str_replace("0.","",(string)number_format(round($getitem[0]->price - (int)$getitem[0]->price,2),2))
        ];
        $images=$item->getImages($id_item);
        $imagesreturn=[];
        foreach($images as $i){
            if(\File::exists($i->address)){
                $imagesreturn[]=$i;
            }
        }
        $return = ["item"=>$getitem,
                   "images"=>$imagesreturn,
                   "descriere"=>$item->getDescription($id_item)
                ];
        return response()->json($return);
    }
    public function addcomentariu(Request $request){
        $id=DB::table("coments")->insertGetId(
                    [
                        "product_id"=>$request->id,
                        "nume"=>$request->nume,
                        "comentariu"=>$request->comentariu,
                        "created_at"=>carbon::now()
                    ]);
        $return=DB::table("coments")->where("id",$id)->first();
        $return->created_at=date('d-m-Y', strtotime($return->created_at));
        return response()->json($return);
                
    }
    public function menu($id)
    {
        $response=DB::table("submenu")
                ->where("menu_id",$id)
                ->get();
        $name=DB::table("menu")
                ->where("id",$id)
                ->value("menu_name");
        return view('menuSubmenu',["response"=>$response,"name"=>$name]);
    }
    public function submenu($id)
    {
        $response=DB::table("itemssubmenu")
                ->where("submenu_id",$id)
                ->get();
        $name=DB::table("submenu")
                ->where("id",$id)
                ->value("submenu_name");
        return view('menuItems',["response"=>$response,"name"=>$name]);
    }
    public function helpbuy(){
        return view("helpbuy");
    }
}
