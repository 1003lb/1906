<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Tools\Wechat;
use App\Tools\Curl;
use App\Model\Channel;
class ChannelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $data=Channel::orderBy('channel_id','desc')->get();
         return view('channel.show',['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $access_token=Wechat::getAccessToken();//获取上传临时素材接口 
        //echo $access_token;die;
       return view('channel.add');
    }

    public function add_do(Request $request){
         $access_token=Wechat::getAccessToken();
    //接值
    $channel_name=$request->input("channel_name");
    $channel_status=$request->input("channel_status");
    //调用微信生成参数
    // $ticket=Wechat::getAccessToken();
    $url="https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$access_token;
//var_dump($url);
//参数
//$postData= '{"expire_seconds": 2592000, "action_name": "QR_STR_SCENE", "action_info": {"scene": {"scene_str": "'.$channel_status.'"}}}';
$postData=[
"expire_seconds"=> 2592000,
"action_name"=>"QR_STR_SCENE",
"action_info"=>[
"scene"=> [
"scene_str"=>$channel_status
        ],
    ],
];
$postData=json_encode($postData,JSON_UNESCAPED_UNICODE);//默认把中文转成 unicode
//echo $postData;die;
//发请求
    $res=Curl::post($url,$postData);
    //var_dump($res);
    $res=json_decode($res,true);
    $ticket=$res['ticket'];
    //入库
    $data=Channel::create([
        'channel_name'=>$channel_name,
        'channel_status'=>$channel_status,
        'ticket'=>$ticket,
        ]);
    if($data){
        echo "<script>alert('添加成功');location.href='/admin/channel_show';</script>";
        }
    }

    
    public function charts(){
    //数据统计图表
        $data=Channel::get()->toArray();

        $xStr="";
        $yStr="";
    foreach ($data as $key => $value) {
        $xStr .='"'.$value['channel_name'].'",';
     $yStr .=$value['num'].',';
        
    }
        $xStr=rtrim($xStr,",");
        $yStr=rtrim($yStr,",");
          ///dd($xStr);
        return view('channel.charst',['xStr'=>$xStr,'yStr'=>$yStr]);
    }
}
