<?php
namespace app\index\controller;
use think\Model;
use think\Db;
/**
* 评论
*/
class Comment extends Common
{
	public function add()
	{	
		$model = model('comment');
		$result = $model->comment();
		if($result === false)
		{
			return json(['statusCode'=>'0','info'=>$model->getError()]);
		}
		return json(['statusCode'=>1,'msg'=>'ok','info'=>$result]);
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
		$model = model('user');
		$result = $model -> login();
		if($result === false)
		{
			return json(['status'=>'0','info'=>$model->getError()]);
		}
		return json(['status'=>1,'msg'=>'ok','info'=>$result]);
	}

	// ajax翻页
	public function ajaxGetPl()
	{
		$goods_id = input('goods_id/d');
		// 当前页
		$page = max(1,input('page/d',1));
		$model = model('comment');
		$data = $model->search($goods_id,$page);
		//dump($data);exit;
		echo json_encode($data);
	}
}