<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use session;
use Image;
use File;
use Carbon\Carbon;

class Menu extends Model
{
    public static function menu(){

                $menu = DB::table('menu')->orderBy("id")->get();
                $submenu = DB::table('submenu')->orderBy("menu_id")->get();
                $itemSubMenu = DB::table('itemssubmenu')->orderBy("submenu_id")->get();
                session::put("menu",$menu);
                session::put("submenu",$submenu);
                session::put("items",$itemSubMenu);
    }
    public function getMenu(){
        $m["menu"]=DB::table('menu')->get(); 
        $m["submenu"]=DB::table('submenu')->get();
        $m["items"]=DB::table('itemssubmenu')->get();
        return $m;
    }
    public function getOneMenu($id){
        return DB::table('menu')->where("id",$id)->get(); 
    }
    public function getOneSubMenu($id){
        return DB::table('submenu')->where("id",$id)->get(); 
    }
    public function getOneItemMenu($id){
        $table=DB::table('itemssubmenu')->where("id",$id)->get();
        $table[1]=DB::table('submenu')->where("id",$table[0]->submenu_id)->first();
        return  $table;
        
    }
    public function addMenu($name){
        if(strlen($name)>0 && strlen($name)<30){
            DB::table('menu')->insert(['menu_name' =>ucwords($name)]);
        }
        else{
            return '0';
        }
    }
    public function modMenu($id,$name){
        if(strlen($name)>0 && strlen($name)<30){
            DB::table('menu')->where('id', $id)->update(['menu_name'=>ucwords($name)]);   
        }
        else{
            return '0';
        }
    }
    public function addSubmenu($request){
        $files=$request->imageSubadd;
        $extensii=["jpeg","jpg","png","svg"];
        if ($request->hasFile('imageSubadd')) {
            if($request->file('imageSubadd')->isValid()){
                $ext=strtolower($files->getClientOriginalExtension());
                if(in_array($ext, $extensii)){
                    if(filesize($files)<6000000){
                        $id=DB::table("submenu")
                                    ->insertGetId([
                                          "submenu_name"=>ucwords($request->nameSubadd),
                                          "submenu_image"=>"",
                                          "submenu_active"=>$request->activSubadd,
                                          "menu_id"=>$request->parinteSubadd,
                                        ]);
                        $date=Carbon::now();
                        $name=$date->format("ymdhis");
                        $path="img/submenu/";
                        if($request->file('imageSubadd')->move($path,$name.".".$ext)){
                            $filename=$path.$name.".".$ext;
                            DB::table("submenu")->where("id",$id)
                                    ->update(["submenu_image"=>$filename,]);
                            Image::make($filename)->fit(300, 300)->save($filename)->destroy();
                            return array('succes'=>true);
                        }else{
                            return array('succes'=>false);
                            DB::table("submenu")->where("id",$id)->delete();
                        }
                    }else{
                        return array('succes'=>false);
                    }
                }else{
                    return array('succes'=>false);
                }
            }else{
                return array('succes'=>false);
            }
        }else{
            return array('succes'=>false);
        }
    }
    public function modSubMenu($request){
        $files=$request->imageSub;
        $extensii=["jpeg","jpg","png","svg"];
        if ($request->hasFile('imageSub')) {
            if($request->file('imageSub')->isValid()){
                $ext=strtolower($files->getClientOriginalExtension());
                if(in_array($ext, $extensii)){
                    if(filesize($files)<6000000){
                        $date=Carbon::now();
                        $name=$date->format("ymdhis");
                        $path="img/submenu/";
                        File::delete(DB::table("submenu")->where("id",$request->id)->value("submenu_image"));
                        if($request->file('imageSub')->move($path,$name.".".$ext)){
                            $filename=$path.$name.".".$ext;
                            Image::make($filename)->fit(300, 300)->save($filename)->destroy();
                            DB::table("submenu")->where("id",$request->id)
                                ->update(["submenu_name"=>ucwords($request->nameSub),
                                          "submenu_image"=>$filename,
                                          "submenu_active"=>$request->activSub,
                                          "menu_id"=>$request->parinteSub,
                                        ]);
                            return array('succes'=>true);
                        }else{
                            return array('succes'=>false);
                        }
                    }else{
                        return array('succes'=>false);
                    }
                }else{
                    return array('succes'=>false);
                }
            }else{
                return array('succes'=>false);
            }
        }else{
            DB::table("submenu")->where("id",$request->id)
                                ->update(["submenu_name"=>ucwords($request->nameSub),
                                          "submenu_image"=>"",
                                          "submenu_active"=>$request->activSub,
                                          "menu_id"=>$request->parinteSub,
                                        ]);
            return array('succes'=>true);
        }
    }
    public function addItems($request){
        $files=$request->imageItemadd;
        $extensii=["jpeg","jpg","png","svg"];
        if ($request->hasFile('imageItemadd')) {
            if($request->file('imageItemadd')->isValid()){
                $ext=strtolower($files->getClientOriginalExtension());
                if(in_array($ext, $extensii)){
                    if(filesize($files)<6000000){
                        $id=DB::table("itemssubmenu")
                                    ->insertGetId([
                                          "item_name"=>ucwords($request->nameitemadd),
                                          "item_image"=>"",
                                          "item_active"=>$request->activItemadd,
                                          "submenu_id"=>$request->subparinteItemadd,
                                        ]);
                        $date=Carbon::now();
                        $name=$date->format("ymdhis");
                        $path="img/itemssubmenu/";
                        if($request->file('imageItemadd')->move($path,$name.".".$ext)){
                            $filename=$path.$name.".".$ext;
                            DB::table("itemssubmenu")->where("id",$id)
                                    ->update(["item_image"=>$filename,]);
                            Image::make($filename)->fit(300, 300)->save($filename)->destroy();
                            return array('succes'=>true);
                        }else{
                            return array('succes'=>false);
                            DB::table("itemssubmenu")->where("id",$id)->delete();
                        }
                    }else{
                        return array('succes'=>false);
                    }
                }else{
                    return array('succes'=>false);
                }
            }else{
                return array('succes'=>false);
            }
        }else{
            return array('succes'=>false);
        }
    }
    public function modItemMenu($request){
        $files=$request->imageItem;
        $extensii=["jpeg","jpg","png","svg"];
        if ($request->hasFile('imageItem')) {
            if($request->file('imageItem')->isValid()){
                $ext=strtolower($files->getClientOriginalExtension());
                if(in_array($ext, $extensii)){
                    if(filesize($files)<6000000){
                        $date=Carbon::now();
                        $name=$date->format("ymdhis");
                        $path="img/itemssubmenu/";
                        File::delete(DB::table("itemssubmenu")->where("id",$request->id)->value("item_image"));
                        if($request->file('imageItem')->move($path,$name.".".$ext)){
                            $filename=$path.$name.".".$ext;
                            Image::make($filename)->fit(300, 300)->save($filename)->destroy();
                            DB::table("itemssubmenu")->where("id",$request->id)
                                ->update(["item_name"=>ucwords($request->nameItem),
                                          "item_image"=>$filename,
                                          "item_active"=>$request->activItem,
                                          "submenu_id"=>$request->subparinteItem,
                                        ]);
                            return array('succes'=>true);
                        }else{
                            return array('succes'=>false);
                        }
                    }else{
                        return array('succes'=>false);
                    }
                }else{
                    return array('succes'=>false);
                }
            }else{
                return array('succes'=>false);
            }
        }else{
            DB::table("itemssubmenu")->where("id",$request->id)
                                ->update(["item_name"=>ucwords($request->nameItem),
                                          "item_active"=>$request->activItem,
                                          "submenu_id"=>$request->subparinteItem,
                                        ]);
            return array('succes'=>true);
        }
    }
}
