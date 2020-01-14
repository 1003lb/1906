<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Curd extends Model
{
      public $primaryKey='c_id';
   public $table='curd';
   public $timestamps=false;
	//黑名单 表设计中允许为空的
   protected $guarded = [];	
   
}
