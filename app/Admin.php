<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Image;
use File;

class Admin extends Model
{
    public function getHomepage(){
        $countproducts=DB::table("products")->count("id");
        $counttabele=DB::table("itemssubmenu")->count("id");
        return ["countproducts"=>$countproducts,
                "counttabele"=>$counttabele,
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
