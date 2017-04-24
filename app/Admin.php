<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Admin extends Model
{
    public static function getAdminPopulars(){
        return DB::table("products")
                ->select('products.*', 'images.address')
                ->leftJoin("images",function($join){
                    $join->on('products.id', '=', 'images.product_id');
                    $join->where('images.default','1');
                })
                ->where("views",">",0)
                ->orderBy("products.views","desc")
                ->take(10)
                ->get();
    }
    public static function getAdminVandute(){
        return DB::table("marfuricomenzi")
                ->select('marfuricomenzi.*', 'images.address',DB::raw('sum(cantitateprodus) as vandut '))
                ->leftJoin("images",function($join){
                    $join->on('marfuricomenzi.id_produs', '=', 'images.product_id');
                    $join->where('images.default','1');
                })
                ->groupBy("marfuricomenzi.id_produs")
                ->orderBy("vandut","desc")
                ->take(10)
                ->get();
    }
    public static function getAdminLastComand(){
        return DB::table("marfuricomenzi")
                ->select('marfuricomenzi.*', 'images.address','comenzi.created_at')
                ->leftJoin("images",function($join){
                    $join->on('marfuricomenzi.id_produs', '=', 'images.product_id');
                    $join->where('images.default','1');
                })
                ->leftJoin("comenzi",function($join){
                    $join->on('marfuricomenzi.id_comenzi', '=', 'comenzi.id');
                })
                ->orderBy("marfuricomenzi.idmarfuri","desc")
                ->take(10)
                ->get();
    }
    public function getHomepage(){
        $countproducts=DB::table("products")->count("id");
        $counttabele=DB::table("itemssubmenu")->count("id");
        $countcomenzi=DB::table("comenzi")->where("trecut",0)->count("id");
        $countcontact=DB::table("contact")->count("id");
        $countcomentarii=DB::table("coments")->count("id");
        $countslideshow=DB::table("slideshow")->count("id");
        $countcontact=DB::table("contact")->count("id");
        $countusers=DB::table("users")->count("id");
        $countadmins=DB::table("admin")->count("id");
        $countallcomenzi=DB::table("comenzi")->count("id");
        $populars=Admin::getAdminPopulars();
        $vandute=Admin::getAdminVandute();
        $comandate=Admin::getAdminLastComand();
        return ["countproducts"=>$countproducts,
                "counttabele"=>$counttabele,
                "countcomenzi"=>$countcomenzi,
                "countcontact"=>$countcontact,
                "countcomentarii"=>$countcomentarii,
                "countslideshow"=>$countslideshow,
                "countusers"=>$countusers,
                "countadmins"=>$countadmins,
                "countallcomenzi"=>$countallcomenzi,
                "populars"=>$populars,
                "vandute"=>$vandute,
                "comandate"=>$comandate,
            ];
    }
    public function getAdmins(){
        $return=DB::table("admin")
                ->where("id","<>",session("idAdmin"))
                ->get();
        return $return;
    }
    public function getEmail($email){
        $este=DB::table('admin')->where('email',  $email)->value('email');
        if(empty($este))
        {
            return false; 
        }
        else
        {
            return true; 
        }
    }
}
