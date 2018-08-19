<?php 
namespace app\index\validate;
use think\Validate;
/**
 * 商品验证器
 */
class Comment extends Validate
{
	// 验证规则
	// require:不能为空,左边的 | 为解释说明,右边的 | 为分割(设置多个验证规则)
	protected $rule = [
		'star' => 'require',
		'content' => 'require',
	];
	//错误信息
	protected $message = [
		'star' => '请评价星数',
		'content' => '内容不能空'
	];
}

?>