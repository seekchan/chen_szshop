<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:58:"D:\Szshop\public/../application/index\view\cart\index.html";i:1533872859;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>购物车页面</title>
	<link rel="stylesheet" href="__HOME__/style/base.css" type="text/css">
	<link rel="stylesheet" href="__HOME__/style/global.css" type="text/css">
	<link rel="stylesheet" href="__HOME__/style/header.css" type="text/css">
	<link rel="stylesheet" href="__HOME__/style/cart.css" type="text/css">
	<link rel="stylesheet" href="__HOME__/style/footer.css" type="text/css">

	<script type="text/javascript" src="__HOME__/js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="__HOME__/js/cart1.js"></script>
	
</head>
<body>
	<!-- 顶部导航 start -->
	<div class="topnav">
		<div class="topnav_bd w990 bc">
			<div class="topnav_left">
				
			</div>
			<div class="topnav_right fr">
				<ul>
					<?php if(empty($userInfo) || (($userInfo instanceof \think\Collection || $userInfo instanceof \think\Paginator ) && $userInfo->isEmpty())): ?>
					<li>您好，欢迎来到京西
					[<a href="<?php echo url('user/login'); ?>">登录</a>] [<a href="<?php echo url('user/regist'); ?>">免费注册</a>] </li>	
					
					<?php else: ?>	
						<li>您好<?php echo $userInfo['username']; ?>，欢迎来到京西！
					<?php endif; ?>
					<li class="line">|</li>
					<li>我的订单</li>
					<li class="line">|</li>
					<li>客户服务</li>

				</ul>
			</div>
		</div>
	</div>
	<!-- 顶部导航 end -->
	
	<div style="clear:both;"></div>
	
	<!-- 页面头部 start -->
	<div class="header w990 bc mt15">
		<div class="logo w990">
			<h2 class="fl"><a href="index.html"><img src="__HOME__/images/logo.png" alt="京西商城"></a></h2>
			<div class="flow fr">
				<ul>
					<li class="cur">1.我的购物车</li>
					<li>2.填写核对订单信息</li>
					<li>3.成功提交订单</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- 页面头部 end -->
	
	<div style="clear:both;"></div>

	<!-- 主体部分 start -->
	<div class="mycart w990 mt10 bc">
		<h2><span>我的购物车</span></h2>
		<table>
			<thead>
				<tr>
					<th class="col1">商品名称</th>
					<th class="col2">商品信息</th>
					<th class="col3">单价</th>
					<th class="col4">数量</th>	
					<th class="col5">小计</th>
					<th class="col6">操作</th>
				</tr>
			</thead>
			<tbody>
			<?php if(is_array($cart) || $cart instanceof \think\Collection || $cart instanceof \think\Paginator): $i = 0; $__LIST__ = $cart;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
				<tr>
					<td class="col1"><a href=""><img src="<?php echo make_img_url($vo['goodsInfo']['goods_img']); ?>" alt="" /></a>  <strong><a href="">【1111购物狂欢节】惠JackJones杰克琼斯纯羊毛菱形格</a></strong></td>
					<td class="col2"> 
					<?php if(is_array($vo['attr']) || $vo['attr'] instanceof \think\Collection || $vo['attr'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['attr'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
					<p><?php echo $v['attr_name']; ?>：<?php echo $v['attr_value']; ?></p> 
					<?php endforeach; endif; else: echo "" ;endif; ?>
					</td>

					<td class="col3">￥<span><?php echo $money[$vo['goods_attr_ids']]['price']; ?></span></td>
					<td class="col4"> 
						<a href="javascript:;" class="reduce_num"></a>
						<input type="text" name="amount" value="<?php echo $vo['goods_count']; ?>" class="amount"/>
						<a href="javascript:;" class="add_num" goods-id="<?php echo $vo['goods_id']; ?>" goods-attr-ids="<?php echo $vo['goods_attr_ids']; ?>"></a>
					</td>
					<td class="col5">￥<span><?php echo $money[$vo['goods_attr_ids']]['price']*$vo['goods_count']; ?></span></td>
					<td class="col6"><a href="<?php echo url('del','id='.$vo['goods_id'].'&attr_ids='.$vo['goods_attr_ids']); ?>">删除</a></td>
				</tr>
			<?php endforeach; endif; else: echo "" ;endif; ?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="6">购物金额总计： <strong>￥ <span id="total"><?php echo $total['money']; ?></span></strong></td>
				</tr>
			</tfoot>
		</table>
		<div class="cart_btn w990 bc mt10">
			<a href="<?php echo url('index/index'); ?>" class="continue">继续购物</a>
			<a href="<?php echo url('order/check'); ?>" class="checkout">结 算</a>
		</div>
	</div>
	<!-- 主体部分 end -->

	<div style="clear:both;"></div>
	<!-- 底部版权 start -->
	<div class="footer w1210 bc mt15">
		<p class="links">
			<a href="">关于我们</a> |
			<a href="">联系我们</a> |
			<a href="">人才招聘</a> |
			<a href="">商家入驻</a> |
			<a href="">千寻网</a> |
			<a href="">奢侈品网</a> |
			<a href="">广告服务</a> |
			<a href="">移动终端</a> |
			<a href="">友情链接</a> |
			<a href="">销售联盟</a> |
			<a href="">京西论坛</a>
		</p>
		<p class="copyright">
			 © 2005-2013 京东网上商城 版权所有，并保留所有权利。  ICP备案证书号:京ICP证070359号 
		</p>
		<p class="auth">
			<a href=""><img src="__HOME__/images/xin.png" alt="" /></a>
			<a href=""><img src="__HOME__/images/kexin.jpg" alt="" /></a>
			<a href=""><img src="__HOME__/images/police.jpg" alt="" /></a>
			<a href=""><img src="__HOME__/images/beian.gif" alt="" /></a>
		</p>
	</div>
	<!-- 底部版权 end -->
</body>
<script type="text/javascript">
	$('.add_num').click(function(){
		// 获取当前的数量 商品id属性值id组合
		var goods_count = parseInt($(this).prev().val());
		goods_count += 1;
		var data = {
			goods_count:goods_count,
			goods_id:$(this).attr('goods-id'),
			goods_attr_ids:$(this).attr('goods-attr-ids'),
		}
		$.ajax({
			url:"<?php echo url('setNum'); ?>",
			data:data,
			type:'post',
			success:function(){
				alert('nice');
			}
		})
	})
</script>
</html>
