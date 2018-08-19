<?php 
namespace app\index\model;
use think\Model;
use think\Db;
/*
*订单模型
*/
class Order extends Model
{
	public function addpay()
	{
		// 订单号
		$order_id = date('YmdHis').rand(100000,999999);
		// 用户ID
		$userInfo = get_user_info();
		$user_id = $userInfo['id'];
		// 金额总数
		$cart = model('cart') -> listData();
		$money = model('cart') -> money($cart); 
		$total = model('cart') -> getTotal($cart,$money);
		$data = [
			'order_id' => $order_id,
			'user_id' => $user_id,
			'consignee' => input('consignee'),
			'address' => input('address'),
			'tel' => input('tel'),
			'addtime' => time(),
			'money' => $total['money'],
		];
		$this -> insert($data);
		$list = [];
		//dump($cart);exit;
		foreach ($cart as $key => $value) {
			$list[] = [
				'order_id' => $order_id,
				'goods_id' => $value['goods_id'],
				'goods_count' => $value['goods_count'],
				'goods_attr_ids' => $value['goods_attr_ids'],
			];
		}
		//dump($list);exit;
		if($list){
			Db::name('order_detail') -> insertAll($list);
			//session('list',$list);
		}
		
		// 实现支付宝支付
		require_once '../extend/alipay/config.php';
		require_once '../extend/alipay/pagepay/service/AlipayTradeService.php';
		require_once '../extend/alipay/pagepay/buildermodel/AlipayTradePagePayContentBuilder.php';

	    //商户订单号，商户网站订单系统中唯一订单号，必填
	    $out_trade_no = $order_id;

	    //订单名称，必填
	    $subject = 'test-pay';

	    //付款金额，必填
	    $total_amount = $total['money'];

	    //商品描述，可空
	    $body = 'desc-pay';

		//构造参数
		$payRequestBuilder = new \AlipayTradePagePayContentBuilder();
		$payRequestBuilder->setBody($body);
		$payRequestBuilder->setSubject($subject);
		$payRequestBuilder->setTotalAmount($total_amount);
		$payRequestBuilder->setOutTradeNo($out_trade_no);

		$aop = new \AlipayTradeService($config);

		/**
		 * pagePay 电脑网站支付请求
		 * @param $builder 业务参数，使用buildmodel中的对象生成。
		 * @param $return_url 同步跳转地址，公网可以访问
		 * @param $notify_url 异步通知地址，公网可以访问
		 * @return $response 支付宝返回的信息
	 	*/
		$response = $aop->pagePay($payRequestBuilder,$config['return_url'],$config['notify_url']);

		//输出表单
		var_dump($response);
	}
}