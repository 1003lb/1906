<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Tools\Wechat;
use App\Tools\Curl;
use App\Model\Media;
class IndexController extends Controller
{
	//首页左边栏
     public function index()
    {
       return view('admin.index.index');
    }

    //首页主页面
    public function index_v1()
    {
       return view('admin.index.index_v1');
    }
    //素材添加页面
     public function add(){
    	$access_token=Wechat::getAccessToken();//获取上传临时素材接口 
    	//echo $access_token;die;

       return view('media.add');
    }
    //素材添加
    public function add_do(Request $request){
    	//接值
    	$data=$request->input();
	//文件上传
	$file = $request->file;
	$ext=$file->getClientOriginalExtension(); //得到文件后缀名
	$filename=md5(uniqid()).".".$ext;
$path=$request->file->storeAs('images',$filename);
//调接口
		$access_token=Wechat::getAccessToken();

		//$type="image";
		$url = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token=".$access_token."&type=".$data['media_format'];
		$filePathObj = new \CURLFile(public_path()."/".$path);//curl发送文件的时候=》CURFIE处理
		//dd($filePathObj);
		//dd($filePath);
		$postData = ['media'=>$filePathObj];
		//dd($postData);
		$res=Curl::post($url,$postData);
			
		$res=json_decode($res,true);
//dd($res);
		$media_id=$res['media_id']; //微信返回的素材id

	//入库
			$res2=Media::create([
				'media_name'=>$data['media_name'],
				'media_format'=>$data['media_format'],
				'media_type'=>$data['media_type'],
				'media_url'=>$path,
				'wechat_media_id'=>$media_id,
				'add_time'=>time(),
			]);
			if($res2){
				echo "<script>alert('添加成功');location.href='/admin/media_show';</script>";
			}
		
	}
    //素材展示
    public function show(){

    	$data=Media::get();
    	//dd($data);
       return view('media.show',['data'=>$data]);
    }


   public function index_weather(){

   	return view('admin.index.weather');
   
   }

   public function getWeather(Request $request){
   	//接收市名
     $city = $request->city;
    // dd($city);
 	//调用接口
   	$url="http://api.k780.com/?app=weather.future&weaid=".$city."&&appkey=10003&sign=b59bc3ef6191eb9f747dd4e83c99f2a4&format=json";
  $sky = file_get_contents($url);
        return $sky; 
   }
}
