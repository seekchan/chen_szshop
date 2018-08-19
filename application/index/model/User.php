<?php 
namespace app\index\model;
use think\Model;
use think\Validate;
use think\captcha\Captcha;
/*
*用户模型
*/
class User extends Model
{
	// 增添用户
	public function addUser()
	{
		$data = input();//dump($data);exit;
		$sessionData = session('telcode');
		$rule = [
			'username' => 'require',
			'password' => 'require',
		];
		// 验证用户密码
		$validate =new Validate($rule);
		if(!$validate -> check($data)){
			$this -> error = '用户名和密码不能为空';
			return false;
		}
		// 查看手机号码是否存在
		if ($this -> get(['tel' => $data['tel']])) {
			$this -> error = '手机号已存在';
			return false;
		}
		if ($sessionData['code'] != $data['telcode']) {
			$this -> error = '短信验证码出错';
			return false;
		}
		if (time() - $sessionData['time']>300) {
			session('telcode',null);
			$this -> error = '短信验证码失效';
			return false;
		}
		if ($sessionData['tel'] != $data['tel']) {
			$this -> error = '小样,还想偷鸡?';
			return false;
		}
		// 验证验证码
		$captcha = new Captcha();
		if (!$captcha -> check($data['captcha'])) {
			$this -> error = '验证码错误';
			return false;
		}
		if ($this -> get(['username' => $data['username']])) {
			$this -> error = '用户名已存在';
			return false;
		}
		if ($data['password'] !== $data['password1']) {
			$this -> error = '两次密码不一致';
			return false;
		}
		unset($data['captcha']);
		unset($data['password1']);
		unset($data['telcode']);
		$data['salt'] = rand(100000,999999);
		// 调用自定义md6方法
		$data['password'] = md6($data['password'],$data['salt']);
		$data['status'] = 1;
		$this -> isUpdate(false) -> save($data);
	}

	// 用户账号登录
	public function login()
	{
		$data = input();// dump($data);exit;
		$rule = [
			'username' => 'require',
			'password' => 'require',
		];
		// 验证用户密码
		$validate =new Validate($rule);
		if(!$validate -> check($data)){
			$this -> error = '用户名和密码不能为空';
			return false;
		}
		$user = $this -> get(['username' => $data['username']]);
		if (!$user) {
			$this -> error = '用户名不存在';
			return false;
		}
		// 验证验证码
		$captcha = new Captcha();
		if (!$captcha -> check($data['captcha'])) {
			$this -> error = '验证码错误';
			return false;
		}
		if($user['password'] !== md6($data['password'],$user['salt'])){
			$this -> error = '密码错误';
			return false;
		}
		// 查看是否激活
		if($user['status'] == 0){
			$this -> error = '账号未激活';
			return false;
		}
		unset($data['captcha']);
		// 保存到cookie中
		$time = isset($data['remember'])?3600*24*7:0;
		unset($user['password']);
		$string = think_encrypt(json_encode($user)); // cookie加密
		cookie('userInfo',$string,$time);
		$a = model('cart')->cookieShift();
	}

	// 用户qq登录
	public function qqLogin($openid,$user)
	{
		// 1、根据openID判断用户是否存在
		// 2、存在用户 手动实现登录  不存在用户写入数据库后实现登录
		$userInfo = $this -> get(['openid'=>$openid]);
		if(!$userInfo){
			$salt = rand(100000,999999);
			// 调用自定义md6方法
			$userInfo = [
				'username' => $user['nickname'].'_'.rand(1000,9999),
				'password' => md6('123456',$salt),
				'salt' => $salt,
				'openid' => $openid,
				'status' => 1,
			];
			$this -> isUpdate(false) -> save($userInfo);
			$userInfo['id'] = $this -> getLastInsId();
		}else{
			// 老用户,可以选择针对用户的信息进行更新
			$this->allowField(true)->isUpdate(true)->save($user,['openid'=>$openid]);
			// 考虑到数据已经更新  因此重新赋值
			$userInfo = $this->get(['openid'=>$openid]);
		}
		// qq登录默认7天免登陆
		$time = 3600*24*7;
		$string = think_encrypt(json_encode($userInfo));
		cookie('userInfo',$string,$time);
		model('cart')->cookieShift();
	}

	// 邮箱注册
	public function registEmail()
	{
		$data = input();//dump($data);exit;
		$sessionData = session('telcode');
		$rule = [
			'username' => 'require',
			'password' => 'require',
			'email' => 'require',
		];
		// 验证用户密码
		$validate =new Validate($rule);
		if(!$validate -> check($data)){
			$this -> error = '用户名,密码,邮箱不能为空';
			return false;
		}
		// 查看用户名是否存在
		if ($this -> get(['username' => $data['username']])) {
			$this -> error = '用户名已存在';
			return false;
		}
		// 查看邮箱是否存在
		if ($this -> get(['email' => $data['email']])) {
			$this -> error = '邮箱已存在';
			return false;
		}
		// 数据入库
		$data['salt'] = rand(100000,999999);
		$data['password'] = md6($data['password'],$data['salt']);
		$this -> isUpdate(false) -> save($data);
		// 发送链接给用户
		$user_id = $this->getLastInsId();
		$key = uniqid();
		$url = "http://szshop.com/index/user/active.html?key=".$key;
		// 将用户的唯一标识保存到memcache中
		require_once "../extend/Mem.php";
		$obj = new \Mem();
		$obj->set($key,$user_id,1800);
		send_email($data['email'],$url);
	}
}

?>