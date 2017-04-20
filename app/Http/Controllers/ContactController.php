<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class ContactController extends Controller
{
    public function contact(){
        return view("contact");
    }
    public function sendproblem(Request $request){
        DB::table("contact")->insert([
            "nume"=>$request->nume,
            "prenume"=>$request->prenume,
            "telefon"=>$request->telefon,
            "email"=>$request->email,
            "problema"=>$request->problema,
            "created_at"=>Carbon::now(3)
        ]);
    }
}
