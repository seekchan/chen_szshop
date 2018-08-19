<?php
namespace app\index\controller;

class Index extends Common
{
	// 热卖
    public function index()
    {
    	$model = model('goods');
    	$is_hot = $model -> getRec('is_hot');
    	$this -> assign('is_hot',$is_hot);
    	// 判断是否为首页
		$this -> assign('is_show',1);
        return $this -> fetch();
    }

    // 退出登录
    public function quit()
    {
        cookie('userInfo',null);
        //$this -> success('退出成功','index');
    }

    public function phpinfo()
    {
        dump(phpinfo());
    }
}
