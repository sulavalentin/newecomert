<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Utilizatori;

class UtilizatoriController extends Controller
{
    public function utilizatori(Utilizatori $utilizatori){
        if (!filter_var(session("emailAdmin"), FILTER_VALIDATE_EMAIL)){
            return redirect("/admin");
        }
        return view("admin.utilizatori",["post"=>$utilizatori->getUtilizatori()]);
    }
}
