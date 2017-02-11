<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Hash;

class Users extends Model
{
    public function getEmail($email){
        $este=Users::where('email',  $email)->value('email');
        if(empty($este))
        {
            return false; 
        }
        else
        {
            return true; 
        }
    }
    public function controlUser($email,$parola){
        $user=Users::where('email' , $email)
                ->where("confirmed" , 1)
                ->first();
        if(empty($user))
        {
            return false;
        }
        else
        {
            if (Hash::check($parola, $user->password)){
                return true;
            }
            else
            {
                return false;
            }
        }
    }
    public function getId($email){
        return Users::Where('email' , $email)
                ->value("id");
    }
    public function getNume($email){
        return Users::Where('email' , $email)
                ->value("name");
    }
    
}
