<?php
namespace app\index\controller;
use think\Model;
use think\Db;
/**
* 回复商品评论控制器
*/
class Reply extends Common
{
	public function reply()
	{
		$model = model('reply');
		$result = $model->reply();
		if($result === false)
		{
			return json(['statusCode'=>'0','info'=>$model->getError()]);
		}
		return json(['statusCode'=>1,'msg'=>'ok','info'=>$result]);
	}
}