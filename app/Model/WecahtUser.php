<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WecahtUser extends Model
{
    public $primaryKey='id';
   public $table='wechat_user';
   public $timestamps=false;
	//黑名单 表设计中允许为空的
   protected $guarded = [];	
}

