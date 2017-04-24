<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Tables extends Model
{
    public function getAllTables(){
        return DB::table('itemssubmenu')->orderBy("id")->paginate(10); 
    }
    public function getTabele($id){
        $coloane=DB::table('specificationgroup')
                ->select('specificationgroup.name_group','specificationname.*','specificationgroup.id as group')
                ->leftJoin("specificationname",function($join){
                     $join->on('specificationgroup.id', '=', 'specificationname.group_id');
                })
                ->where('specificationgroup.table_id',$id)
                ->get();
        $aseaza=[];
        foreach($coloane as $key => $item)
        {
           $aseaza[$item->name_group][$key] = $item;
        }
        return $aseaza;
    }
    public function saveColumn($request){
        $table=$request->table; 
        $id=$request->id;
        $group=$request->group_id;
        $update=$request->update;
        $name=$request->name;
        $addname=$request->addname;
        $addsearch=$request->addsearch;
        for($i=3;$i<count($id);$i++){
            if($id[$i]=="new"){
                $id[$i]=DB::table("specificationname")->insertGetId(["table_id"=>$table,
                    "group_id"=>$group[$i],
                    "specification_name"=>$update[$i]]);
            }else{
                DB::table("specificationname")
                        ->where("id",$id[$i])
                        ->update(["specification_name"=>$update[$i],
                                  "addname"=>(int)$addname[$i],
                                  "addsearch"=>(int)$addsearch[$i]]);
            }
            if(!empty($name[$i]) && $name[$i]=="delete"){
                DB::table("specificationname")
                        ->where("id",$id[$i])
                        ->delete();
                DB::table("specifications")
                        ->where("specification_id",$id[$i])
                        ->delete();
            }
        }
    }
    public function addGroup($request){
        $id=DB::table('specificationgroup')
            ->insertGetId(["table_id"=>$request->table,
                            "name_group"=>$request->value]);
        return $id;
    }
    public function modificaColoana($id,$value){
        DB::table('specificationgroup')
            ->where('id', $id)
            ->update(['name_group' =>ucwords($value)]);
        return $value;
    }
    public function deleteColoana($id){
        $spec=DB::table("specificationname")
                ->where("group_id",$id)
                ->pluck("id");
        DB::table("specificationgroup")
                ->where("id",$id)
                ->delete();
        DB::table("specificationname")
                ->where("group_id",$id)
                ->delete();
        foreach($spec as $key){
            DB::table("specifications")
                ->where("specification_id",$key)
                ->delete();
        }
        
    }
}
