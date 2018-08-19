<?php 
namespace app\admin\controller;
use think\Controller;
use think\Model;
use think\captcha\Captcha;
use think\Session;
/*
 后台管理员登录
 */
class Login extends Controller
{   
	// 后台登录界面
	public function index()
	{   
		if($this -> request -> isGet())
		{
			return $this -> fetch();	
		}
		//校验密码
		$model = model('admin');   
		$result = $model -> login();
		if($result === false)
		{
			$this -> error($model->getError());	
		}		
		$this -> success('奈斯','index/index');
	}

	// 验证码
	public function captcha()
	{
		$config = ['length' => 3,'codeSet' => '123'];
		$obj = new Captcha($config);
		return $obj -> entry();
	}

	public function clear()
    {
        cookie('admin_id',null);
        cache('user_power_'.cookie('admin_id'),null);
        $this -> success('退出成功','admin/login/index');
    }
}

?>