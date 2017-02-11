<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Admin;
use App\Products;
use App\Tables;
use App\Menu;
use DB;

class AdminController extends Controller
{
    public function base(Admin $admin){
        if (filter_var(session("emailAdmin"), FILTER_VALIDATE_EMAIL)){
            $count=$admin->getHomepage();
            return view("admin.home",$count);
        }else{
            return redirect("/admin/login");
        }
    }
    public function products(Products $products){
        if (filter_var(session("emailAdmin"), FILTER_VALIDATE_EMAIL)){
            return view("admin.produse",["items"=>$products->getAllItems()]);
        }else{
            return redirect("/admin/login");
        }
    }
    public function tables(Tables $tables){
        if (filter_var(session("emailAdmin"), FILTER_VALIDATE_EMAIL)){
            return view("admin.tabele",["tabele"=>$tables->getAllTables()]);
        }else{
            return redirect("/admin/login");
        }
    }
    public function menu(Menu $menu){
        if (filter_var(session("emailAdmin"), FILTER_VALIDATE_EMAIL)){
            return view("admin.menu",["menu"=>$menu->getMenu()]); 
        }else{
            return redirect("/admin/login");
        }
    }
    public function getLogin(){
        $first=DB::table("admin")->where("confirmed",1)->count();
        if($first>0){
            return view('admin.partials.login');
        }else{
            return view("admin.partials.register");
        }
    }
    public function getRegister(){
        return view('admin.partials.register');
    }
    public function reset(){
        return view("admin.partials.reset");
    }
}
