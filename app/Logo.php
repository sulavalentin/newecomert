<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Logo extends Model
{
    public static function getInfo(){
        $logo=DB::table('logo')->where("variable","logo")->first();
        return ["logo"=>$logo];
    }
}
