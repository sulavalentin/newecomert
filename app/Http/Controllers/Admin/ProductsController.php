<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Products;
use Image;
use File;
use Carbon\Carbon;

class ProductsController extends Controller
{
    public function getProducts(Products $products,$id){
        if (!filter_var(session("emailAdmin"), FILTER_VALIDATE_EMAIL)){
            return redirect("/admin");
        }
        return view("admin.itemsproduse",["article"=>$products->getProducts($id),
                                          "items"=>$products->getAllItems()]);
    }
    public function getoneadd(Request $request,  Products $products){
       if (!filter_var(session("emailAdmin"), FILTER_VALIDATE_EMAIL)){
            return redirect("/admin");
        }
        return $products->getOneAdd($request->table);
    }
    public function getoneitem(Request $request,  Products $products){
       if (!filter_var(session("emailAdmin"), FILTER_VALIDATE_EMAIL)){
            return redirect("/admin");
        }
        return $products->getOneItem($request->element,$request->table);
    }
    
    public function addItem(Request $request , Products $products){
        if (!filter_var(session("emailAdmin"), FILTER_VALIDATE_EMAIL)){
            return redirect("/admin");
        }
        $tabela=$request->table;
        return $products->addItem($request,$tabela);
    }
    public function modificaItem(Request $request , Products $products){
        if (!filter_var(session("emailAdmin"), FILTER_VALIDATE_EMAIL)){
            return redirect("/admin");
        }
        $tabela=$request->table;
        $id=$request->id;
        return $products->modificaItem($request,$tabela,$id);
    }
    public function deleteItem(Request $request , Products $products){
        if (!filter_var(session("emailAdmin"), FILTER_VALIDATE_EMAIL)){
            return redirect("/admin");
        }
        $id=$request->id;
        return $products->deleteItem($id);
    }
    public function deleteImage(Request $request){
        if (!filter_var(session("emailAdmin"), FILTER_VALIDATE_EMAIL)){
            return redirect("/admin");
        }
        $id=$request->id;
        $item_id=$request->item_id;
        $name=DB::table("images")->where("id",$id)->select("address","default")->first();
        if(File::exists($name->address)){
            File::delete($name->address);
        }
        if($name->default==1){
            $check=DB::table("images")
                    ->where("product_id",$item_id)
                    ->value("id");
            if(!empty($check)){
                DB::table("images")->where("id",$check)->update(["default"=>1]);
            }
        }
        return $id;
    }
    public function deleteAllImages(Request $request){
        if (!filter_var(session("emailAdmin"), FILTER_VALIDATE_EMAIL)){
            return redirect("/admin");
        }
        $images=DB::table("images")->where("product_id",-1)->get();
        foreach($images as $key){
            if(File::exists($key->address)){
                File::delete($key->address);
            }
            DB::table("images")->where("id",$key->id)->delete();
        }
        
    }
    public function defaultImage(Request $request){
        if (!filter_var(session("emailAdmin"), FILTER_VALIDATE_EMAIL)){
            return redirect("/admin");
        }
        $id=$request->id;
        $item_id=$request->item_id;
        DB::table("images")
            ->where("product_id",$item_id)
            ->where("default",1)
            ->update(["default"=>0]);
        DB::table("images")
            ->where("id",$id)
            ->update(["default"=>1]);
    }
    public function upload(Request $request)
    {
        if (!filter_var(session("emailAdmin"), FILTER_VALIDATE_EMAIL)){
            return redirect("/admin");
        }
        $response=[];
        $files=$request->file("file");
        $prod=$request->id;
        $extensii=["jpeg","jpg","png","svg"];
        if ($request->hasFile('file')) {
            foreach($files as $file){
                if($file->isValid()){
                    $ext=strtolower($file->getClientOriginalExtension());
                    if(in_array($ext, $extensii)){
                        if(filesize($file)<6000000){
                            $date=Carbon::now();
                            $name=$date->format("ymdhis")+DB::table("images")->orderby("id","desc")->value('id')+1;
                            $path="img/products/items/";
                            if($file->move($path,$name.".".$ext)){
                                $filename=$path.$name.".".$ext;
                                Image::make($filename)->fit(450, 450)->save($filename)->destroy();
                                $check=DB::table("images")
                                        ->where("product_id",$prod)
                                        ->where("default",'1')
                                        ->first();
                                $insert=["address"=>$filename,
                                        "product_id"=>$prod];
                                $id=0;
                                if(empty($check)){
                                    $insert+=["default"=>1];
                                    $id=DB::table("images")->insertGetId($insert);
                                }else{
                                    $id=DB::table("images")->insertGetId($insert);
                                }
                                $response[]=["succes"=>true,
                                             "image"=>asset($filename),
                                             "id"=>$id];
                            }
                        }
                    }
                }
            }
            return $response;
        }else{
            return Response::json(array('succes'=>"notfound"));
        }
    }
}
