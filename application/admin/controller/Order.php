<?php 
namespace app\admin\controller;
use think\Controller;
use think\Db;

// 订单控制器
class Order extends Controller
{  
	// 显示订单界面 
   	public function index()
   	{ 
   		$order = Db::name('order') -> paginate(5);
   		$this -> assign('order',$order);
   		return $this -> fetch();
   	}

   	// 发货信息
   	public function send()
   	{
   		if ($this->request->isGet()) {
   			return $this -> fetch();
   		}
   		$data = input();
   		$data['status'] = 2;
   		Db::name('order') -> where(['id'=>$data['id']]) -> update($data);
   	}
}