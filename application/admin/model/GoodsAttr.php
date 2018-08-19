<?php 
namespace app\admin\model;
use think\Model;
/*
商品模型
 */
class GoodsAttr extends Model
{
	public function add_attr_value($goods_id,$attr)
	{
		$list = []; // dump($attr);exit;
		foreach ($attr as $key => $value){
			$value = array_unique($value);
			foreach ($value as $v){
				$list[] = [
				'goods_id'   => $goods_id,
				'attr_id'    => $key,
				'attr_value' => $v,	
				];		
			}		
		}
		// dump($list);exit;
		if($list){
			$this -> insertAll($list);
		}	
	}

	public function get_attr_value($goods_id)
	{
		$attr = $this -> alias('a') -> join('shop_attribute b','a.attr_id=b.id','left') -> where('a.goods_id',$goods_id) -> field('a.attr_value,b.*') -> select(); 

		foreach ($attr as $key => $value) {
			$value = $value -> toArray();
			if($value['attr_input_type'] == 2){
				$value['attr_values'] = explode(',', $value['attr_values']);
			}
			$data[] = $value;
		}  //dump($data);exit;
		$attrData = [];
		foreach ($data as $key => $value) {
			$attrData[$value['id']][] = $value;
		}     //dump($attrData);exit;
		return $attrData;
	}
}