<?php 
namespace app\admin\validate;
use think\Validate;
/**
 * 验证器类
 */
class Test extends Validate
{
	// 指定验证规则
	protected $rule = [
		'name' => 'require|max:25',
		'age|年龄' => 'require|checkAge:abc'
	];
	//自定义错误信息
	protected $message = [
		'name.require' => '名称必须填写',
		'name.max' => '名称长度错误'
	];
	// 指定场景
	protected $scene = [
		'add' => ['email','age'],
		'edit' => ['name']
	];
	// 自定义的方法进行验证  $value为数据本身
	// $rele为之后的传递的参数 $data为完整数据
	public function checkAge($value,$rule,$data)
	{
		if($value <=0 || $value > 150)
		{
			return false;
		}
		return true;
	}
}

?>