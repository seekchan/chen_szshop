<?php 
namespace app\admin\model;
use think\Model;
use think\Db;
//管理员模型类
class Sku extends Model
{
	public function addSku()
	{
		$attr = input('attr/a');
		$goods_id = input('id/d');
		$price = input('price');
		$sku_num = input('sku_num');  
		$attr_ids = [];
		$attr_ids = implode(',', $attr);//dump($attr_ids);

		// 数据入库
		$data = [
			'goods_id' => $goods_id,
			'price' => $price,
			'standards' => $attr_ids,
			'sku_num' => $sku_num, 
		];
		$ids = $this -> where(['goods_id'=>$goods_id])->field('standards')->select();//dump($ids);exit;
		if ($ids == $attr_ids) {
			$this -> where(['goods_id'=>$goods_id,'standards'=>$attr_ids])->update(['price'=>$price,'sku_num'=>$sku_num]);
		}else{
			
			$this -> insert($data);
		}
		
	}

}