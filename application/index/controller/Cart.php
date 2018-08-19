<?php
namespace app\index\controller;
use think\Model;
use think\Db;
/*
*购物控制器
*/
class Cart extends Common
{
	// 提交购物单
	public function addCart()
	{
		$goods_id = input('id/d');
		$goods_count = input('goods_count/d');
		$goods_attr_ids = input('attr/a');
		$goods_attr_ids = $goods_attr_ids?implode(',', $goods_attr_ids):'';
		$where = [
			'goods_id'=>$goods_id,
			'standards'=>$goods_attr_ids,
		];
		$sku_num = Db::name('sku')->where($where)->field('sku_num')->find();
		if($sku_num['sku_num']==0 || $sku_num['sku_num']-$goods_count<0){
			$this->error('库存不足');
		}
		$model = model('cart');
		$result = $model -> addCart($goods_id,$goods_count,$goods_attr_ids);
		if ($result === false) {
			$this -> error($model -> getError());
			return false;
		}
		$this -> success('ok','index');
	}
	// 购物车界面显示
	public function index()
	{
		$cart = model('cart') -> listData();  //dump($cart);exit;
		$data = $goods_id = [];
		// 商品价格
		$money = model('cart') -> money($cart);
		// 商品总价
		$total = model('cart') -> getTotal($cart,$money);//dump($total);exit;
		$this -> assign('cart',$cart); 
		$this -> assign('total',$total);
		$this -> assign('money',$money);
		return $this -> fetch();
	}

	// 购物删除
	public function del()
	{
		$cart = model('cart') -> del();
		$this -> success('nice','index');
	}

	// ajax商品数量增加
	public function setNum()
	{
		$result = model('cart') -> setNum();
		return json(['status'=>1]);
	}
	public function test()
	{
		dump(cookie('cart'));exit;
	}
}
