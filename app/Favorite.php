<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Favorite extends Model
{
    public static function getCountFavorite()
    {
        $response=DB::table("favorite")->where("user_id",session("id"))->count("id");
        return $response;
    }
}
