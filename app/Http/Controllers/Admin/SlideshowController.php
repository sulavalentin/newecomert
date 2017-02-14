<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use File;
use Image;
use DB;

class SlideshowController extends Controller
{
    public function addslideshow(Request $request){
        if (!filter_var(session("emailAdmin"), FILTER_VALIDATE_EMAIL)){
            return redirect("/admin");
        }
        $link=$request->link;
        $response=[];
        $files=$request->file("file");
        $extensii=["jpeg","jpg","png","svg"];
        if ($request->hasFile('file')){
            if($files->isValid()){
                $ext=strtolower($files->getClientOriginalExtension());
                if(in_array($ext, $extensii)){
                    $date=Carbon::now();
                    $name=$date->format("ymdhis");
                    $path="img/slideshow/";
                    if($files->move($path,$name.".".$ext)){
                        $filename=$path.$name.".".$ext;
                        $id=DB::table("slideshow")->insertGetId(["link"=>$link,"image"=>$filename]);
                        $return=DB::table("slideshow")->where("id",$id)->first();
                        $response=["succes"=>true,
                                   "link"=>$return];
                    }
                }
            }
            return response()->json($response);
        }else{
            return response()->json(array('succes'=>"notfound"));
        }
    }
    public function delslideshow(Request $request){
        if (!filter_var(session("emailAdmin"), FILTER_VALIDATE_EMAIL)){
            return redirect("/admin");
        }
        $id=$request->id;
        $valoare=DB::table("slideshow")->where("id",$id)->value("image");
        if(File::exists($valoare)){
            File::delete($valoare);
        }
        DB::table("slideshow")->where("id",$id)->delete();
        return response()->json($id);
    }
}
