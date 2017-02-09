<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tables;
class TablesController extends Controller
{
    public function getTabele(Tables $tables,Request $request){
        if (!filter_var(session("emailAdmin"), FILTER_VALIDATE_EMAIL)){
            return redirect("/admin");
        }
        return $tables->getTabele($request->id);
    }
    
    public function saveTable(Request $request , Tables $tables){
        if (!filter_var(session("emailAdmin"), FILTER_VALIDATE_EMAIL)){
            return redirect("/admin");
        }
        return $tables->saveColumn($request);
    }
    public function addGroup(Request $request , Tables $tables){
        if (!filter_var(session("emailAdmin"), FILTER_VALIDATE_EMAIL)){
            return redirect("/admin");
        }
        return $tables->addGroup($request);
    }
    public function modificaColoana(Request $request , Tables $tables){
        if (!filter_var(session("emailAdmin"), FILTER_VALIDATE_EMAIL)){
            return redirect("/admin");
        }
        $id=$request->id;
        $value=$request->value;
        return $tables->modificaColoana($id,$value);
    }
    public function deleteColoana(Request $request , Tables $tables){
        if (!filter_var(session("emailAdmin"), FILTER_VALIDATE_EMAIL)){
            return redirect("/admin");
        }
        $id=$request->id;
        return $tables->deleteColoana($id);
    }
}
