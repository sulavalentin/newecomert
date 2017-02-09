<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use session;

class Menu extends Model
{
    public static function menu(){

                $menu = DB::table('menu')->orderBy("id")->get();
                $submenu = DB::table('submenu')->orderBy("menu_id")->get();
                $itemSubMenu = DB::table('itemssubmenu')->orderBy("submenu_id")->get();
                session::put("menu",$menu);
                session::put("submenu",$submenu);
                session::put("items",$itemSubMenu);
    }
}
