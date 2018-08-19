<?php
namespace app\index\controller;
use think\Model;
use think\Db;
/*
*下单控制器
*/
class Order extends Common
{
	// 下单后界面显示
	public function check()
	{
		$this -> checkLogin();
		$cart = model('cart') -> listData();
		$money = model('cart') -> money($cart);
		$total = model('cart') -> getTotal($cart,$money);
		$this -> assign('cart',$cart); 
		$this -> assign('money',$money);
		$this -> assign('total',$total);
		return $this -> fetch();
	}

	// 订单信息入库
	public function pay()
	{
		$this -> checkLogin();
		$result = model('order') -> addpay();
		if ($result === false) {
			$this -> error('下单失败');
		}
		$this -> success('ok');
	}

	// 订单界面显示
	public function index()
	{	
		$userInfo = get_user_info();
		$order = Db::name('order')->alias('a')->join('shop_order_detail b','a.order_id=b.order_id','left')->where('user_id',$userInfo['id'])->field('a.*,b.goods_id,b.goods_count,b.goods_attr_ids')->select();

		// 查询商品图片
		$img = [];
		foreach ($order as $key => $value) {
			$img[$value['goods_attr_ids']]=Db::name('goods')->where(['id'=>$value['goods_id']])->field('goods_img')->find();
		}//dump($img);exit;
		$this -> assign('img',$img);
		$this -> assign('order',$order);
		return $this -> fetch();
	}

	// 查看物流信息
	public function express()
	{	
		$order_id = input('id/d');
		$data = Db::name('order')->where('id',$order_id)->find();
		$url = "http://v.juhe.cn/exp/index?key=1cc5266eb3e581d139c237d5c7e06d2d&com=".$data['com']."no".$data['waybill'];
		$res = file_get_contents($url);
		$data = json_decode($res,true);//dump($data );exit;
		$this->assign('data',$data['result']['list']);
		return $this->fetch();
	}
}