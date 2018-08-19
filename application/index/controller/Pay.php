<?php 
namespace app\index\controller;
use think\Controller;
use think\Db;
/*
*订单模型
*/
class Pay extends Controller
{
	public function returnUrl()
	{
		require_once("../extend/alipay/config.php");
		require_once '../extend/alipay/pagepay/service/AlipayTradeService.php';


		$arr=$_GET;
		$alipaySevice = new \AlipayTradeService($config); 
		$result = $alipaySevice->check($arr);

		/* 实际验证过程建议商户添加以下校验。
		1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
		2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
		3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
		4、验证app_id是否为该商户本身。
		*/
		if($result) {//验证成
			//请在这里加上商户的业务逻辑程序代码
			
			//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
		    //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表

			//商户订单号
			$out_trade_no = htmlspecialchars($_GET['out_trade_no']);

			//支付宝交易号
			$trade_no = htmlspecialchars($_GET['trade_no']);
				
			db('order')->where(['order_id'=>$out_trade_no])->setField('status',1);
			// 当订单完成时  把模板中的订单清除
				$orderData = db('order_detail')->where(['order_id'=>$out_trade_no])->select();
				$user = get_user_info();
				foreach ($orderData as $key => $value) {
					// 清空购物车
					db('cart')->where(['goods_id'=>$value['goods_id'],'goods_attr_ids'=>$value['goods_attr_ids'],'user_id'=>$user['id']])->delete();
					// 商品规格对应的库存减少
					Db::query("UPDATE shop_sku SET sku_num=sku_num-$value[goods_count] WHERE goods_id=$value[goods_id] AND standards='$value[goods_attr_ids]'");
				}
				
			//echo "验证成功<br />支付宝交易号：".$trade_no;

			//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
		}
		else {
		    //验证失败
		    echo "参数异常";
		}
	}

	// 异步回调
	public function notifyUrl()
	{
		require_once '../extend/alipay/config.php';
		require_once '../extend/alipay/pagepay/service/AlipayTradeService.php';

		$arr=$_POST;
		$alipaySevice = new \AlipayTradeService($config); 
		$alipaySevice->writeLog(var_export($_POST,true));
		$result = $alipaySevice->check($arr);

		/* 实际验证过程建议商户添加以下校验。
		1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
		2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
		3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
		4、验证app_id是否为该商户本身。
		*/
		if($result) {
		    //验证成功
			//请在这里加上商户的业务逻辑程序代
			//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
		    //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
			//商户订单号

			$out_trade_no = $_POST['out_trade_no'];

			//支付宝交易号

			$trade_no = $_POST['trade_no'];

			//交易状态
			$trade_status = $_POST['trade_status'];

			// 获取用户的订单相关的信息
			$orderinfo = db('order')->where(['order_id'=>$out_trade_no])->find();
			if ($orderinfo) {
				echo "fail";exit;
			}
			if ($orderinfo['status'] == 0) {
				// 再次处理订单
				db('order')->where(['order_id'=>$out_trade_no])->setField('status',1);
				$orderData = db('order_detail')->where(['order_id'=>$out_trade_no])->select();
				$user = get_user_info();
				foreach ($orderData as $key => $value) {
					// 清空购物车
					db('cart')->where(['goods_id'=>$value['goods_id'],'goods_attr_ids'=>$value['goods_attr_ids'],'user_id'=>$user['id']])->delete();
					// 商品规格对应的库存减少
					Db::query("UPDATE shop_sku SET sku_num=sku_num-$value[goods_count] WHERE goods_id=$value[goods_id] AND standards='$value[goods_attr_ids]'");
				}
			}
			
			
		    if($_POST['trade_status'] == 'TRADE_FINISHED') {

				//判断该笔订单是否在商户网站中已经做过处理
				//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
				//请务必判断请求时的total_amount与通知时获取的total_fee为一致的
				//如果有做过处理，不执行商户的业务程序
						
				//注意：
				//退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知
		    }
		    else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
				//判断该笔订单是否在商户网站中已经做过处理
				//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
				//请务必判断请求时的total_amount与通知时获取的total_fee为一致的
				//如果有做过处理，不执行商户的业务程序			
				//注意：
				//付款完成后，支付宝系统发送该交易状态通知
		    }
			//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
			echo "success";	//请不要修改或删除
		}else {
		    //验证失败
		    echo "fail";
			}
	}
}