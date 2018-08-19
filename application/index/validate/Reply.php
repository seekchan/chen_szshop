<?php 
namespace app\index\validate;
use think\Validate;
/**
 * 商品验证器
 */
class Reply extends Validate
{
	// 验证规则
	// require:不能为空,左边的 | 为解释说明,右边的 | 为分割(设置多个验证规则)
	protected $rule = [
		'comment_id' => 'require',
		'content' => 'require',
	];
	//错误信息
	protected $message = [
		'comment_id' => '参数错误',
		'content' => '内容不能空'
	];
}

?>