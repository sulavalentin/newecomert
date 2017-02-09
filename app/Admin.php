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
}
