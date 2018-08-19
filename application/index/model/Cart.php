<?php 
namespace app\index\model;
use think\Model;
use think\Db;
/*
*购物模型
*/
class Cart extends Model
{
	public function addCart($goods_id,$goods_count,$goods_attr_ids)
	{
		// 判断是否登录
		$userInfo = get_user_info();
		if ($userInfo) {
			// 已登录
			$where = [
				'user_id' => $userInfo['id'],
				'goods_id' => $goods_id,
				'goods_attr_ids' => $goods_attr_ids,
			];
			if ($this -> get($where)) {
				$this -> where($where) -> setInc('goods_count',$goods_count);
			}else{
				$where['goods_count'] = $goods_count;
				$this -> isupdate(false) -> save($where);
			}
		}else{
			// 未登录
			$cart = cookie('cart')?cookie('cart'):[];
			$key = $goods_id.'-'.$goods_attr_ids;
			if (array_key_exists($key, $cart)) {
				// cookie中存在
				$cart[$key] += $goods_count;
			}else{
				// cookie中不存在
				$cart[$key] = $goods_count;
			}
			cookie('cart',$cart);
		}	
	}

	// 购物车数据显示
	public function listData()
	{
		// 判断是否登录
		$userInfo = get_user_info();
		$list = [];
		if ($userInfo) {
			// 已登录
			$list = Db::name('cart')->where(['user_id'=>$userInfo['id']])->select();
		}else{
			// 未登录
			$cart = cookie('cart')?cookie('cart'):[]; 
			foreach ($cart as $key => $value) {
				$tmp = explode('-', $key);
				$list[] = [
					'goods_count' => $value,
					'goods_id' => $tmp[0],
					'goods_attr_ids' => $tmp[1],
				];
			}
		}
		foreach ($list as $key => $value) {
			// 商品基本信息
			$list[$key]['goodsInfo'] = Db::name('goods')->where('id',$value['goods_id'])->find();
			// 商品属性值
			$list[$key]['attr'] = Db::name('attribute')->alias('a')->field('a.attr_name,b.attr_value')->join('goods_attr b','a.id=b.attr_id','left')->where('b.id','in',$value['goods_attr_ids'])->select();
		}
		// dump($list);exit;
		return $list;
	}

	public function money($cart)
	{
		$money = [];
		foreach ($cart as $key => $value) {
			$goods_id = $value['goods_id'];
			$ids = $value['goods_attr_ids'];
			$sku = Db::name('sku') -> where('goods_id',$goods_id)->select();
			//$money = [];
			foreach ($sku as $key => $v) {
				if ($v['standards'] == $ids) {
					$money[$ids]['price'] = $v['price'];
				}	
			} 
		} //dump($money);exit;
		return $money;
	}

	// 计算总数
	public function getTotal($cart,$all)
	{
		$number = $money = 0;
		foreach ($cart as $key => $value) {
			$number += $value['goods_count'];
			$money += $value['goods_count']*$all[$value['goods_attr_ids']]['price']; 
		}
		return ['money'=>$money,'number'=>$number];
	}

	// 购物删除
	public function del()
	{
		$goods_id = input('id');
		$goods_attr_ids = input('attr_ids');
		$userInfo = get_user_info();
		if ($userInfo) {
			$where = [
				'goods_id' => $goods_id,
				'goods_attr_ids' => $goods_attr_ids,
			];
			$this -> where($where) -> delete();
		}else{
			$cart = cookie('cart')?cookie('cart'):[];
			$key = $goods_id.'-'.$goods_attr_ids;
			unset($cart[$key]);
			cookie('cart',$cart,3600*24*7);
		}
	}

	// ajax商品增加
	public function setNum()
	{
		$data = input();
		$userInfo = get_user_info();
		if ($userInfo) {
			$where = [
				'user_id' => $userInfo['id'],
				'goods_id' => $data['goods_id'],
				'goods_attr_ids' => $data['goods_attr_ids'],
			];
			$this -> where($where) -> update(['goods_count'=>$data['goods_count']]);dump(1);
		}else{ 
			$cart = cookie('cart')?cookie('cart'):[];
			$key = $data['goods_id'].'-'.$data['goods_attr_ids'];
			$cart[$key] = $data['goods_count'];
			cookie('cart',$cart,3600*24*7);
		}
	}

	// 登录时把未登录时的cookie中的购物车里的商品转移到数据库
	public function cookieShift()
	{
		$userInfo = get_user_info();
		$cart = cookie('cart')?cookie('cart'):[];
		foreach ($cart as $key => $value) {
			$tmp = explode('-',$key);
			$where = [
				'user_id' => $userInfo['id'],
				'goods_id' => $tmp[0],
				'goods_attr_ids' => $tmp[1],
			];

			// 判断数据库是否存在  有则更新  没有则添加
			$result = $this -> where($where) -> find();
			if ($result) {
				$this -> where($where) -> update(['goods_count'=>$value]);
			}else{
				$where['goods_count'] = $value;
				$this -> insert($where);
			}
		}
		cookie('cart',null);
	}
}