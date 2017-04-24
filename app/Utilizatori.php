<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Utilizatori extends Model
{
    public function getUtilizatori(){
        return DB::table("users")->orderby("id","desc")->paginate(10);
    }
}
