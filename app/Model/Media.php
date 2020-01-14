<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    public $primaryKey='media_id';
   public $table='media';
   public $timestamps=false;
	//黑名单 表设计中允许为空的
   protected $guarded = [];	
}
