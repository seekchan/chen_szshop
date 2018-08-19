<?php 
namespace app\admin\validate;
use think\Validate;
/**
* 属性验证器
*/
class Attribute extends Validate
{
	protected $rule = [
		'attr_name' => 'require',
		//'attr_id' => 'require|gt:0',
		'attr_type' => 'require|in:1,2',
		'attr_input_type' => 'require|in:1,2',
	];
}

?>