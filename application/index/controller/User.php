<?php 
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\captcha\Captcha;
class User extends Common
{	
	// 用户注册
	public function regist()
	{
		if ($this -> request -> isGet()) {
			return $this -> fetch();
		}
		$model = model('user');
		$result = $model -> addUser();
		if ($result === false) {
			$this -> error($model -> getError());
			return false;
		}
		$this -> success('注册成功');
	}

	// 短信验证码
	public function sendSms()
	{
		$tel = input('tel');
		$code = rand(1000,9999);
		$res = send_sms($tel,[$code,5],1);
		if (!$res) {
			return json(['status'=>0,'msg'=>'fail']);
		}
		// 保存验证码
		return session('telcode',['code'=>$code,'time'=>time(),'tel'=>$tel]);
		return json(['status'=>1,'msg'=>'ok']);
	}

	// 验证码
	public function captcha()
	{
		$config = ['length' => 3,'codeSet' => '123'];
		$obj = new Captcha($config);
		return $obj -> entry();
	}

	// 登录
	public function login()
	{
		if ($this -> request -> isGet()) {
			return $this -> fetch();
		}
		$model = model('user');
		$result = $model -> login();
		if ($result === false) {
			$this -> error($model -> getError());
			return false;
		}
		$a =model('cart') -> cookieShift();
		$this -> success('登录成功','index/index');
	}

	// qq登录
	public function callback()
	{   
		require_once("../extend/qq/API/qqConnectAPI.php");
		$qc = new \QC();
		// 获取到的access_token
		$access_token = $qc-> qq_callback();
		// 获取到的用户的openID
		$openid = $qc-> get_openid();
		$qc = new \QC($access_token,$openid);
		$user = $qc -> get_user_info(); //dump($user);
		model('User') -> qqLogin($openid,$user);
	}
	// qq请求
	public function oauth()
	{
		require_once("../extend/qq/API/qqConnectAPI.php");
		$qc = new \QC();
		$qc-> qq_login();
	}

	// 邮箱注册
	public function registemail()
	{
		if ($this-> request ->isGet()) {
			return $this -> fetch();
		}
		$model = model('user');
		$result = $model->registEmail();
		if ($result === false) {
			$this -> error($model -> getError());
			return false;
		}
		$this -> success('注册成功');
	}

	// 邮箱注册激活
	public function active()
	{
		$key = input('key');
		require_once "../extend/Mem.php";
		$obj = new \Mem();
		$value = $obj->get($key);
		if (!$value) {
			// 可以引导再次发送激活邮件
			$this->error('连接地址失效','user/regist');
		}
		Db::name('user')->where('id',$value)->setField('status',1);
		echo "ok";
	}

	// 测试cookie
	public function test1()
	{	
		
		$data = get_user_info();
		dump($data);
		dump(cookie('userInfo'));
	}
    // 测试短信
	public function test2()
	{
		dump(session('telcode'));
	}
	// 测试发邮件
	public function test3()
	{	
		dump(send_email('chenszshop@163.com','telcode'));
	}
}