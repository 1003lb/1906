<?php
//echo 'hgfhfjfj';die;
//echo 7;die;

//提交按钮 微信服务器get请求=》echostr
//原样输出echostr即可
//$echostr=$_GET['echostr'];
//echo $echostr;die;
$student=['薛斌英','刘世杰','牛群','孙嘉豪'];
//接入完成之后，微信公众号内用户任何操作 微信服务器=》post形式 发送到配置的url上
$xml=file_get_contents("php://input");//接收原始的xml或json数据流
//var_dump($xml);exit;
//写文件里
file_put_contents("1.txt","\n".$xml."\n",FILE_APPEND);
//方便处理XML=>对象s
$xmlObj=simplexml_load_string($xml);

//如果是关注
if($xmlObj->MsgType == 'event' && $xmlObj->Event == 'subscribe'){
//回复文本消息
 reponseText($xmlObj,"欢迎关注,  熬夜不掉头发回复1  撩最帅小哥哥回复2  天气信息回复3");
}
//如果是用户发送文本消息
if($xmlObj->MsgType == 'text'){
	$content=trim($xmlObj->Content);
	if($content == '1'){
		reponseText($xmlObj,"想什么呢？还有这美事？摸摸你你脑袋上还有几根！啥也不是.睡觉！");
	}elseif($content == '2'){
		$msg=implode(",",$student);
		reponseText($xmlObj,$msg);//回复学生姓名

	}elseif($content == '3'){
		//随机回复最帅的
		shuffle($student);
		$msg=$student[0];
		reponseText($xmlObj,$msg);
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
reponseText($xmlObj,$msg);
	}
}
function reponseText($xmlObj,$msg){
	echo "<xml>
  <ToUserName><![CDATA[".$xmlObj->FromUserName."]]></ToUserName>
  <FromUserName><![CDATA[".$xmlObj->ToUserName."]]></FromUserName>
  <CreateTime>".time()."</CreateTime>
  <MsgType><![CDATA[text]]></MsgType>
 <Content><![CDATA[".$msg."]]></Content>
</xml>";die;
}
?>
