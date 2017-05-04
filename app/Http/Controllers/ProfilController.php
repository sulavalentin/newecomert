<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use Hash;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ProfilController extends Controller
{
    public function profil(){
        if(!(session("id")>0)){
            return redirect("/");
        }
        $profil=DB::table("users")
                ->where("id",session("id"))
                ->first();
        $return=DB::table('comenzi')
                ->select('comenzi.*', 'marfuricomenzi.*','images.address')
                ->leftJoin("marfuricomenzi",function($join){
                    $join->on('comenzi.id', '=', 'marfuricomenzi.id_comenzi');
                })
                ->leftJoin("images",function($join){
                    $join->on('marfuricomenzi.id_produs', '=', 'images.product_id');
                    $join->where('images.default','1');
                })
                ->where('comenzi.user_id',session("id"))
                ->where('comenzi.deleteduser',0)
                ->orderby('comenzi.id','desc')
                ->get();
        $arr=[];
        foreach($return as $i){
            $arr[$i->id]["nume"]=[
                "id"=>$i->id,
                "data"=>$i->created_at,
                "nume"=>$i->nume,
                "email"=>$i->email,
                "telefon"=>$i->telefon,
                "adresa"=>$i->adresa,
                "new"=>$i->new
            ];
            $arr[$i->id]["produse"][$i->idmarfuri]=[
                "imagine"=>$i->address,
                "originalname"=>$i->originalnameprodus,
                "name"=>$i->nameprodus,
                "price"=>$i->priceprodus,
                "cantitate"=>$i->cantitateprodus,
                "idprodus"=>$i->id_produs,
                "total"=>$i->cantitateprodus*$i->priceprodus
            ];
        }
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $col = new Collection($arr);
        $perPage = 10;
        $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $return = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage);
        $return->setPath(URL('/profil'));
        return view("profil",["profil"=>$profil,"comenzi"=>$return]);
    }
    public function changenameuser(Request $request){
        $name=$request->name;
        $email=$request->email;
        if(strlen($name)>0 && strlen($name)<100 && filter_var($email, FILTER_VALIDATE_EMAIL)){
            DB::table("users")->where("id",session("id"))->update(["name"=>$name,"email"=>$email]);
            session(["nume"=>$name,]);
        }
    }
    public function changepassworduser(Request $request){
        $parolaveche=$request->parolaveche;
        $password=$request->password;
        $repeatpassword=$request->repeatpassword;
        $return=[];
        $parola=DB::table("users")->where("id",session("id"))->value("password");
        if(strlen($parola)>10){
            if(Hash::check($parolaveche,$parola)){
                if(strlen($password)>=6 && strlen($password)<50){
                    if(strcmp($password,$repeatpassword)==0){
                        DB::table("users")->where("id",session("id"))->update(["password"=>bcrypt(strtolower($password))]);
                        return response()->json(true);
                    }else{
                        $return["repeatpassword"]="*";
                    }
                }else{
                    $return["password"]="*";
                }
            }else{
                $return["parolaveche"]="*";
            }
        }else{
            if(strlen($password)>=6 && strlen($password)<50){
                if(strcmp($password,$repeatpassword)==0){
                    DB::table("users")->where("id",session("id"))->update(["password"=>bcrypt(strtolower($password))]);
                    return response()->json(true);
                }else{
                    $return["repeatpassword"]="*";
                }
            }else{
                $return["password"]="*";
            }
        }
        return $return;
    }
    public function stergecomanda(Request $request){
        DB::table("comenzi")->where("id",$request->id)->update(["deleteduser"=>1]);
    }
}
