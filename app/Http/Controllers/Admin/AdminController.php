<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Admin;
use App\Products;
use App\Tables;
use App\Menu;
use App\Slideshow;
use DB;

class AdminController extends Controller
{
    public function base(Admin $admin){
        if (!filter_var(session("emailAdmin"), FILTER_VALIDATE_EMAIL)){
            return redirect("/admin/login");
        }
        $count=$admin->getHomepage();
        return view("admin.home",$count);
    }
    public function products(Products $products){
        if (!filter_var(session("emailAdmin"), FILTER_VALIDATE_EMAIL)){
            return redirect("/admin/login");
        }
        return view("admin.produse",["items"=>$products->getAllItems()]);
    }
    public function tables(Tables $tables){
        if (!filter_var(session("emailAdmin"), FILTER_VALIDATE_EMAIL)){
            return redirect("/admin/login");
        }
        return view("admin.tabele",["tabele"=>$tables->getAllTables()]);
    }
    public function menu(Menu $menu){
        if (!filter_var(session("emailAdmin"), FILTER_VALIDATE_EMAIL)){
           return redirect("/admin/login");
        }
         return view("admin.menu",["menu"=>$menu->getMenu()]); 
    }
    public function slideshow(Slideshow $slideshow){
        if (!filter_var(session("emailAdmin"), FILTER_VALIDATE_EMAIL)){
           return redirect("/admin/login");
        }
        return view("admin.slideshow",["slideshow"=>$slideshow->getSlideshow()]);
    }
    public function admins(Admin $admin){
        if (!filter_var(session("emailAdmin"), FILTER_VALIDATE_EMAIL)){
           return redirect("/admin/login");
        }
        return view("admin.admins",["admins"=>$admin->getAdmins()]);
    }
    public function getLogin(){
        if (filter_var(session("emailAdmin"), FILTER_VALIDATE_EMAIL)){
           return redirect("/admin");
        }
        $first=DB::table("admin")->where("confirmed",1)->count();
        if($first>0){
            return view('admin.partials.login');
        }else{
            return view("admin.partials.register");
        }
    }
    public function reset(){
        return view("admin.partials.reset");
    }
    /*Admini*/
    public function deleteadmin(Request $request){
        if (!filter_var(session("emailAdmin"), FILTER_VALIDATE_EMAIL)){
           return redirect("/admin/login");
        }
        $id=$request->id;
        $permision=DB::table("admin")->where("confirmed",1)->first();
        $session=session("idAdmin");
        if($permision->id==$session){
            DB::table("admin")->where("id",$id)->delete();
            return response()->json(true);
        }else{
            return response()->json(false);
        }
    }
}
