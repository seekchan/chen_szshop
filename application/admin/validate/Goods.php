<?php 
namespace app\admin\validate;
use think\Validate;
/**
 * 商品验证器
 */
class Goods extends Validate
{
	// 验证规则
	// require:不能为空,左边的 | 为解释说明,右边的 | 为分割(设置多个验证规则)
	// gt:0 为 =0 
	protected $rule = [
		'goods_name' => 'require',
		'shop_price|本店售价' => 'require|gt:0',
		'cate_id' => 'require|gt:0',
		'market_price' => 'require|checkMarketPrice'
	];
	//错误信息
	protected $message = [
		'goods_name.require' => '商品名称不能为空',
		'cate_id' => '请选择分类'
	];
	// 检查市场价格
	public function checkMarketPrice($value,$rule,$data)
	{
		if($value <= $data['shop_price'])
		{
			return false;
		}
		return true;
	}
}

?>