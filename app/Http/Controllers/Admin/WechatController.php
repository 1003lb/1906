<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Tools\Wechat;
use App\Tools\Curl;
use App\Model\Channel;
use App\Model\WecahtUser;
class WechatController extends Controller
{
    private $student=['薛斌英','刘世杰','牛群','孙嘉豪'];

    //微信开发者配置服务器
    public function index(Request $request)
    {
          // echo "成功";
     //微信接入
  //$echostr=$request->input('echostr');die;
 
 $xml=file_get_contents("php://input");//接收原始的xml或json数据流
//var_dump($xml);exit;
//写文件里
file_put_contents("log.txt","\n".$xml."\n",FILE_APPEND);
//方便处理XML=>对象s
$xmlObj=simplexml_load_string($xml);

//如果是关注
if($xmlObj->MsgType == 'event' && $xmlObj->Event == 'subscribe'){
//关注时获取用户基本信息
$data=Wechat::getUserInfoByOpenId($xmlObj->FromUserName);
// dd($data);
// var_dump($data);die;
//得到渠道的标识
//$eventKey=$xmlObj->EventKey;//截取字符串
$channel_status=$data['qr_scene_str'];
//dd($channel_status);
//感觉渠道标识注人数递增
  $res=Channel::where(['channel_status'=>$channel_status])->increment('num');
//dd($res);

//承认用户基本信息 渠道标识

$nickname=$data['nickname'];//获取到用户昵称

  if($data['sex']==2){
    $sex = "女士";
  }elseif($data['sex']==1){
    $sex = "先生";
  }elseif($data['sex']==0){
    $sex = "一位不愿意透露性别的隐士";
  }
$msg="欢迎".$nickname.$sex."关注";

//回复文本消息
 wechat::reponseText($xmlObj,$msg);
}

//如果是用户发送文本消息
if($xmlObj->MsgType == 'text'){
    $content=trim($xmlObj->Content);
    if($content == '1'){
       wechat::reponseText($xmlObj,"想什么呢？还有这美事？摸摸你你脑袋上还有几根！啥也不是.睡觉！");
    }elseif($content == '2'){
        $msg=implode(",",$this->student);
       wechat::reponseText($xmlObj,$msg);//回复学生姓名

    }elseif($content == '3'){
        //随机回复最帅的
        shuffle($this->student);
        $msg=$this->student[0];
     wechat::reponseText($xmlObj,$msg);
    }elseif(mb_strpos($content ,'天气') !== false){ //城市名称+天气
        //回复天气
        $city=rtrim($content,"天气");
        if(empty($city)){
            $city="枣庄";
        }
        $url="http://api.k780.com/?app=weather.future&weaid=".$city."&&appkey=10003&sign=b59bc3ef6191eb9f747dd4e83c99f2a4&format=json";
//参数传递好

//调用接口 （GET POST）
$data=file_get_contents($url);
$data=json_decode($data,true);
//var_dump($data);

$msg="";
foreach ($data['result'] as $key => $value){
    $msg .=$value['days']." ".$value['week']." ".$value['citynm']." ".$value['temperature']."\n";
}
wechat::reponseText($xmlObj,$msg);
             }
        }
    }

  public function createMenu(){
    $access_token = Wechat::getAccessToken();
    $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
    $postData = [
            "button" =>[
                [
                    "type"  => "click",
                    "name"  => "777",
                    "key"   => "1906weixin"
                ],
                [


                    "name"=>"菜单",


                    "sub_button"=>[

                        [
                            "type"=>"view",
                            "name"=>"搜索",
                            "url"=>"http://www.soso.com/"
                        ],
                        [
                                "type"  => "scancode_push",
                                "name"  => "扫一扫",
                                "key"   => "scan111"
                        ],
                        [
                            "type"  => "pic_sysphoto",
                                "name"  => "拍照",
                                "key"   => "photo111"
                        ]

                    ],
                ]

            ]
        ];

    $postData = json_encode($postData,JSON_UNESCAPED_UNICODE);
    //dd($postData);
    $res = Curl::post($url,$postData);
    $res = json_decode($res,true);
    dd($res);
  }
}
