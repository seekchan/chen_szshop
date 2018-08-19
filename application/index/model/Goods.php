<?php 
namespace app\index\model;
use think\Model;
use think\Db;
/*
*商品模型
*/
class Goods extends Model
{
	// 热卖显示
	public function getRec($field)
	{
		$key = 'index_rec_'.$field;
		//cache($key,null);
		$info = cache($key);
		if (!$info) {
			$info = $this->where(['is_del'=>0,$field=>1,'is_sale'=>1])->limit(5)->select();  //dump($info);exit;
			cache($key,$info);
		}
		return $info;
		
	}

	// 设置库存
	public function setSku($goods_id,$ids)
	{
		$ids = implode(',', $ids);   // dump($ids);
		$sku = Db::name('sku') -> where('goods_id',$goods_id)->select();
		$list = [];
		foreach ($sku as $key => $value) {
			if ($value['standards'] == $ids) {
				$list['price'] = $value['price'];
				$list['sku_num'] = $value['sku_num'];
			}	
		} //dump($list);exit;
        return $list; 
	}

	// 面包屑导航
	public function navigation($cate_id)
	{
		static $res = [];
		$data = Db::name('category')->find($cate_id);
		$res[] = $data;
		if ($data['parent_id']>0) {
			$this->navigation($data['parent_id']);
		}
		return $res;
	}

	// 最近浏览过的商品
	public function history($goods_id)
	{	
		// 先从cookie中取出浏览历史的ID数组
		$data = cookie('history') ? unserialize(cookie('history')) : [];
		// 把最新浏览的这件商品放到数组中的第一位置上
		array_unshift($data, $goods_id);
		// 去重
		$data = array_unique($data);
		// 只取数组中的前6个
		if (count($data) > 6) {
			$data = array_slice($data,0,6);
		}
		// 数组存回cookie
		cookie('history',serialize($data),3600*24*7);
		$data = implode(',', $data);
		// 再根据商品的ID取出商品的详细信息
		$history = Db::name('goods')->where(['id'=>['in',$data],'is_sale'=>1])->select();
		return $history;
	}
}