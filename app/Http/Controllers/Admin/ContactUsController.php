<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class ContactUsController extends Controller
{
    public function getcontact(){
        if (!filter_var(session("emailAdmin"), FILTER_VALIDATE_EMAIL)){
            return redirect("/admin/login");
        }
        $post=DB::table("contact")->paginate(10);
        return view('admin.contact',['post'=>$post]);
    }
    public function delproblema(Request $request){
        if (!filter_var(session("emailAdmin"), FILTER_VALIDATE_EMAIL)){
            return redirect("/admin/login");
        }
        DB::table("contact")->where("id",$request->id)->delete();
    }
}
