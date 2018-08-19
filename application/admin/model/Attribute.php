<?php 
namespace app\admin\model;
use think\Model;
use think\Db;
/**
* 属性模型类
*/
class Attribute extends Model
{
	// 商品属性首页数据
	public function listAttr()
	{
		/*$data = $this -> alias('a') -> field('a.*,t.type_name') -> join('type t','t.id=a.type_id','left') -> paginate(5);
		return $data;*/
		//dump($data);exit;
		// mysql优化
	  	$typeInfo = get_type_info();
		$attr = $this -> all();
		foreach ($attr as $v) {
			$v = $v -> toArray(); 
			$v['type_name'] = $typeInfo[$v['type_id']]['type_name'];
			$data[] = $v;
		}
		return $data;
	}

	// 根据类型id获取属性信息
	public function getTypeAttr($type_id)
	{
		$data = $this -> all(['type_id' => $type_id]);
		foreach ($data as $key => $value) {
			$value = $value -> toArray(); 
			if($value['attr_input_type'] == 2)
			{
				$value['attr_values'] = explode(',', $value['attr_values']);
			}
			$list[] = $value; 
		}
		// dump($list);exit;
		return $list;
	}

}

?>