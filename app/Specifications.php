<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specifications extends Model
{
    protected $fillable = ['product_id', 'specification_id', 'value'];
}
