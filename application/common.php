<?php
if(!function_exists('send_email')){
    /**
     * 邮箱注册
     */
  function send_email($to,$body,$Subject='邮箱注册')
  {
    require '../extend/PHPMailer/class.phpmailer.php';
    $mail             = new \PHPMailer();
    /*服务器相关信息*/
    $mail->IsSMTP();   //启用smtp服务发送邮件                  
    $mail->SMTPAuth   = true;  //设置开启认证             
    $mail->Host       = 'smtp.163.com';      //指定smtp邮件服务器地址  
    $mail->Username   = 'chenszshop';   //指定用户名 
    $mail->Password   = 'a258258';   //邮箱的第三方客户端的授权密码
    /*内容信息*/
    $mail->IsHTML(true);
    $mail->CharSet    ="UTF-8";     
    $mail->From       = 'chenszshop@163.com';     
    $mail->FromName   ="你彬哥"; //发件人昵称
    $mail->Subject    = $Subject; //发件主题
    $mail->MsgHTML($body);  //邮件内容 支持HTML代码
    $mail->AddAddress($to);  //收件人邮箱地址
    //$mail->AddAttachment("test.png"); //附件
    $mail->Send();      //发送邮箱
  }
}

if(!function_exists('send_sms')){
    /**
     * 发送短信验证码
     */
	function send_sms($to,$datas,$tempId)
	{
		include_once("../extend/CCPRestSmsSDK.php");
		//主帐号,对应开官网发者主账号下的 ACCOUNT SID
		$accountSid= '8a216da864da60ef0164e5b957fe0480';
		//主帐号令牌,对应官网开发者主账号下的 AUTH TOKEN
		$accountToken= '9c0475c9d6914fc49fa979a8caf4cb19';
		//应用Id，在官网应用列表中点击应用，对应应用详情中的APP ID
		//在开发调试的时候，可以使用官网自动为您分配的测试Demo的APP ID
		$appId='8aaf070864d9dc630164e5bf1f260586';
		//请求地址
		//沙盒环境（用于应用开发调试）：sandboxapp.cloopen.com
		//生产环境（用户应用上线使用）：app.cloopen.com
		$serverIP='sandboxapp.cloopen.com';
		//请求端口，生产环境和沙盒环境一致
		$serverPort='8883';
		//REST版本号，在官网文档REST介绍中获得。
		$softVersion='2013-12-26';

		$rest = new \REST($serverIP,$serverPort,$softVersion);
	    $rest->setAccount($accountSid,$accountToken);
	    $rest->setAppId($appId);
	    $result = $rest->sendTemplateSMS($to,$datas,$tempId);
     
	    if($result == NULL ) {
	            return false;
	        }
      if($result->statusCode!=0) {
          return false;
      }
	 return true;
	}
}

// 组装资源服务器上的图片地址
if (!function_exists('make_img_url')) {
    function make_img_url($url)
    {
      return config('res_domain').'/'.$url; 
    }
}
// 获取用户登录信息
if (!function_exists('get_user_info')) {
    function get_user_info()
    {
      $userInfo = cookie('userInfo');
      if (!$userInfo) {
        return false;
      }
      // 反解密码
      $string = think_decrypt($userInfo);
      if (!$string) {
        return false;
      }
      return json_decode($string,true);
    }  
}
// md6双重加密
if(!function_exists('md6'))
{
    function md6($password,$salt = '123456')
    {
      return md5(md5($password.$salt));
    }

}
// redis缓存
if(!function_exists('get_type_info'))
{
    function get_type_info()
    {
      $typeInfo = cache('type_info');  // type_info是自定义的文件名,保存数据在redis中
      if(!$typeInfo)
      {
          $type = db('type') -> select();   
          foreach ($type as $value)
          {    
            $typeInfo[$value['id']] = $value;
          }
          cache('type_info',$typeInfo,3600);
      }
      return $typeInfo;
    }

}
// 封装的ajax
function ajaxMsg($status, $msg, $data) 
{
    header("content-type: textml;charset=utf-8");
    $ajax = array(
        "status" => $status,
        "msg" => $msg
    );

    if ($data) {
        $ajax['data'] = $data;
    }

    echo json_encode($ajax,JSON_UNESCAPED_UNICODE);
    exit();
}

//分类数据格式化
//$data 为格式化的数据
//$id 为需要寻找某个分类下的子分类  为0表示寻找所有的分类
//$lev 为层次
if(!function_exists('get_cate_tree'))
{
    function get_cate_tree($data,$id=0,$lev=1,$isClear=false)
    {  
   		static $list = [];
      if($isClear)
      {
        $list = [];
      }
   		foreach($data as $value)
   		{
   			// 转换为数组格式
   			//$value = $value -> toArray();
   			if($value['parent_id']==$id)
   			{   
   				$value['lev']=$lev;
   				$list[]=$value;
   				get_cate_tree($data,$value['id'],$lev+1);
   			}
   		}
   		return $list;
    }
} 

// ftp资源共享
if(!function_exists('upload_img_to_cdn'))
{
  /**
   * 转移文件到资源服务器
   * $image 要转移资源的本地地址
   * $newpath 上传到资源服务器上的目录(不带家目录地址)
   * return  bollean
   */
  function upload_img_to_cdn($image,$newpath='')
  {
    include_once '../extend/ftp.php';
    // 读取配置项
    $config = config('cdn');
    $ftp = new \ftp($config['host'],$config['port'],$config['user'],$config['pass']);
    $newpath = $newpath?$newpath:$image;
    return $ftp -> up_file($image,$newpath);
  }
} 

/**
 * 系统加密方法
 * @param string $data 要加密的字符串
 * @param string $key  加密密钥
 * @param int $expire  过期时间 单位 秒
 * return string
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function think_encrypt($data, $expire = 0,$key = '') {
    $key  = md5(empty($key) ? config('DATA_AUTH_KEY') : $key);
    $data = base64_encode($data);
    $x    = 0;
    $len  = strlen($data);
    $l    = strlen($key);
    $char = '';
    for ($i = 0; $i < $len; $i++) {
        if ($x == $l) $x = 0;
        $char .= substr($key, $x, 1);
        $x++;
    }
    $str = sprintf('%010d', $expire ? $expire + time():0);
    for ($i = 0; $i < $len; $i++) {
        $str .= chr(ord(substr($data, $i, 1)) + (ord(substr($char, $i, 1)))%256);
    }
    return str_replace(array('+','/','='),array('-','_',''),base64_encode($str));
}
/**
 * 系统解密方法
 * @param  string $data 要解密的字符串 （必须是think_encrypt方法加密的字符串）
 * @param  string $key  加密密钥
 * return string
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function think_decrypt($data, $key = ''){
    $key    = md5(empty($key) ? config('DATA_AUTH_KEY') : $key);
    $data   = str_replace(array('-','_'),array('+','/'),$data);
    $mod4   = strlen($data) % 4;
    if ($mod4) {
       $data .= substr('====', $mod4);
    }
    $data   = base64_decode($data);
    $expire = substr($data,0,10);
    $data   = substr($data,10);
    if($expire > 0 && $expire < time()) {
        return '';
    }
    $x      = 0;
    $len    = strlen($data);
    $l      = strlen($key);
    $char   = $str = '';
    for ($i = 0; $i < $len; $i++) {
        if ($x == $l) $x = 0;
        $char .= substr($key, $x, 1);
        $x++;
    }
    for ($i = 0; $i < $len; $i++) {
        if (ord(substr($data, $i, 1))<ord(substr($char, $i, 1))) {
            $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
        }else{
            $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
        }
    }
    return base64_decode($str);
}