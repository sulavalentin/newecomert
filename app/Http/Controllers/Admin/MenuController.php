<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Menu;
use DB;

class MenuController extends Controller
{
    public function getOnemenu(Request $request , Menu $menu){
        if (!filter_var(session("emailAdmin"), FILTER_VALIDATE_EMAIL)){
            return redirect("/admin");
        }
        return $menu->getOneMenu($request->id);
    }
    public function getOnesubmenu(Request $request , Menu $menu){
        if (!filter_var(session("emailAdmin"), FILTER_VALIDATE_EMAIL)){
            return redirect("/admin");
        }
        return $menu->getOneSubMenu($request->id);
    }
    public function getOneitemssubmenu(Request $request , Menu $menu){
        if (!filter_var(session("emailAdmin"), FILTER_VALIDATE_EMAIL)){
            return redirect("/admin");
        }
        return $menu->getOneItemMenu($request->id);
    }
    public function addMenu(Request $request , Menu $menu){
        if (!filter_var(session("emailAdmin"), FILTER_VALIDATE_EMAIL)){
            return redirect("/admin");
        }
        return $menu->addMenu($request->name);
    }
    public function addSubmenu(Request $request , Menu $menu){
        if (!filter_var(session("emailAdmin"), FILTER_VALIDATE_EMAIL)){
            return redirect("/admin");
        }
        return $menu->addSubmenu($request);
    }
    public function addItemssubmenu(Request $request , Menu $menu){
        if (!filter_var(session("emailAdmin"), FILTER_VALIDATE_EMAIL)){
            return redirect("/admin");
        }
        return $menu->addItems($request);
    }
    
    public function modMenu(Request $request , Menu $menu){
        if (!filter_var(session("emailAdmin"), FILTER_VALIDATE_EMAIL)){
            return redirect("/admin");
        }
        return $menu->modMenu($request->id,$request->name);
    }
    public function modSubmenu(Request $request , Menu $menu){
        if (!filter_var(session("emailAdmin"), FILTER_VALIDATE_EMAIL)){
            return redirect("/admin");
        }
        return $menu->modSubMenu($request);
    }
    public function modItemssubmenu(Request $request , Menu $menu){
        if (!filter_var(session("emailAdmin"), FILTER_VALIDATE_EMAIL)){
            return redirect("/admin");
        }
        return $menu->modItemMenu($request);
    }
}
