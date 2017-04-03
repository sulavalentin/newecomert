<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Users;
use Session;
use Socialite;
use DB;
use Carbon\Carbon;
use Mail;
use Crypt;
use App\Cart;

class RegisterController extends Controller
{
    public function goToFacebook($prov){
        return Socialite::driver($prov)->redirect();
    }
    public function goToFacebookBack(Users $users , $prov){
        try
        {
            $userfb=Socialite::driver($prov)->user();
        }  
        catch (Exception $e)
        {
            return false;
        }
        $auth=DB::table("users")
                ->where("email",$userfb->email)
                ->first();
        if(!$auth){
            $exist=DB::table("users")
                ->where("email",$userfb->email)
                ->first();
            DB::table("users")
                    ->insert(["social_id"=>$userfb->id,
                            "email"=>$userfb->email,
                            "name"=>$userfb->name,
                            "created_at"=>Carbon::now(),
                            "confirmed"=>1,
                            ]);
        }
        $email=$userfb->email;
        session::put("nume",$users->getNume($email));
        session::put("id",$users->getId($email)); 
        return redirect("/");
    }
    public function login(Request $request,Users $users)
    {
        $email=strtolower($request->input("email"));
        $parola=strtolower($request->input("parola"));
        $logat=false;
        if($users->controlUser($email,$parola))
        {
            $logat=true;
            session::put("nume",$users->getNume($email));
            session::put("id",$users->getId($email)); 
        }
        return response()->json($logat);
    }
    public function register(Request $request, Users $users)
    {
        $nume=strtolower($request->input("nume"));
        $email=strtolower($request->input("email"));
        $parola=strtolower($request->input("parola"));
        $rparola=strtolower($request->input("rparola"));
        $register=[]; 
        $inscrie=true;
        if (strlen($nume)==0 || strlen($nume)>25){
            $register["nume"]="Nume*"; 
            $inscrie=false;
        }
        if (filter_var($email, FILTER_VALIDATE_EMAIL)){
            if ($users->getEmail($email)){
                $register["email"]="Email ocupat"; 
                $inscrie=false;
            }
        }else{
            $register["email"]="Introduceti un email*"; 
            $inscrie=false;
        }
        if (strlen($parola)<6 || strlen($parola)>50){
            $register["parola"]="Parola*"; 
            $inscrie=false;
        }
        else 
            if (strcmp($parola,$rparola)!=0){
                $register["rparola"]="Parolele nu corespund*"; 
                $inscrie=false;
            }
        if($inscrie){
            $token=str_random(32);
            $user = new Users;
            $user->name = $nume;
            $user->email = $email;
            $user->password = bcrypt($parola);
            $user->confirmation_code=$token;
            $user->timestamps = false;
            $user->created_at = Carbon::now();
            $user->save();
            Mail::send('emails.comfirm', ['email' => Crypt::encrypt($email) , 'token' => $token], function ($m) use ($email) {
                $m->to($email)->subject('Cod comfirmare email');
            });
            $register["salogat"]=true;
        }
        return response()->json($register);
    }
    public function comfirm(Users $users , $email,$token){
        $email=Crypt::decrypt($email);
        $confirmation=DB::table("users")
                ->where("email",$email)
                ->where("confirmation_code",$token)
                ->first();
        if($confirmation){
            DB::table("users")
                    ->where("email",$email)
                    ->update(["confirmed" => 1 , "confirmation_code" =>null]);
            session::put("nume",$users->getNume($email));
            session::put("id",$users->getId($email)); 
            return view("tanks.emailconfirmed",["succes"=>true]);
        }else{
            return view("tanks.emailconfirmed",["succes"=>false]);
        }
        
    }
    public function exituser()
    {
        session()->forget('nume');
        session()->forget('id');
        return redirect("/");
    }
}
