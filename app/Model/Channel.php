<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
     public $primaryKey='channel_id';
   public $table='channel';
   public $timestamps=false;
	//黑名单 表设计中允许为空的
   protected $guarded = [];	
}
