<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
class Logo extends Model
{
    public static function getInfo(){
        $logo=DB::table('logo')->where("variable","logo")->first();
        return ["logo"=>$logo];
    }
    public static function views(){
        $views = DB::table("logo")->where("variable","views")->first();
        session::put("views",true);
        if(is_null($views)){
            DB::table("logo")->insert(["variable"=>"views","valuevariable"=>1]);
        }else{
            $endviews=$views->valuevariable+1;
            DB::table("logo")->where("variable","views")->update(["valuevariable"=>$endviews]);
        }
    }
    public static function getviews(){
        return DB::table("logo")->where("variable","views")->first();
    }
}
