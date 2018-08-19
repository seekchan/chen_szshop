<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:61:"D:\Szshop\public/../application/index\view\order\express.html";i:1533906904;s:61:"D:\Szshop\public/../application/index\view\public\header.html";i:1533892452;s:61:"D:\Szshop\public/../application/index\view\public\footer.html";i:1532315431;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>订单页面</title>
	<link rel="stylesheet" href="__HOME__/style/base.css" type="text/css">
	<link rel="stylesheet" href="__HOME__/style/global.css" type="text/css">
	<link rel="stylesheet" href="__HOME__/style/header.css" type="text/css">
	<link rel="stylesheet" href="__HOME__/style/home.css" type="text/css">
	<link rel="stylesheet" href="__HOME__/style/order.css" type="text/css">
	<link rel="stylesheet" href="__HOME__/style/bottomnav.css" type="text/css">
	<link rel="stylesheet" href="__HOME__/style/footer.css" type="text/css">

	<script type="text/javascript" src="__HOME__/js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="__HOME__/js/header.js"></script>
	<script type="text/javascript" src="__HOME__/js/home.js"></script>
</head>
<body>
	<!-- 顶部导航 start -->
<div class="topnav">
	<div class="topnav_bd w1210 bc">
		<div class="topnav_left">
			
		</div>
		<div class="topnav_right fr">
			<ul>
			<?php if(empty($userInfo) || (($userInfo instanceof \think\Collection || $userInfo instanceof \think\Paginator ) && $userInfo->isEmpty())): ?>
				<li>您好，欢迎来到京西
				[<a href="<?php echo url('user/login'); ?>">登录</a>] [<a href="<?php echo url('user/regist'); ?>">免费注册</a>] </li>	
				
			<?php else: ?>	
			<li>您好<?php echo $userInfo['username']; ?>，欢迎来到京西！</li>
			<li ><a href="" onclick="quit()"  >退出</a></li>
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

<!-- 头部 start -->
<div class="header w1210 bc mt15">
	<!-- 头部上半部分 start 包括 logo、搜索、用户中心和购物车结算 -->
	<div class="logo w1210">
		<h1 class="fl"><a href="index.html"><img src="__HOME__/images/logo.png" alt="京西商城"></a></h1>
		<!-- 头部搜索 start -->
		<div class="search fl">
			<div class="search_form">
				<div class="form_left fl"></div>
				<form action="" name="serarch" method="get" class="fl">
					<input type="text" class="txt" value="请输入商品关键字" /><input type="submit" class="btn" value="搜索" />
				</form>
				<div class="form_right fl"></div>
			</div>
			
			<div style="clear:both;"></div>

			<div class="hot_search">
				<strong>热门搜索:</strong>
				<a href="">D-Link无线路由</a>
				<a href="">休闲男鞋</a>
				<a href="">TCL空调</a>
				<a href="">耐克篮球鞋</a>
			</div>
		</div>
		<!-- 头部搜索 end -->

		<!-- 用户中心 start-->
		<div class="user fl">
			<dl>
				<dt>
					<em></em>
					<a href="">用户中心</a>
					<b></b>
				</dt>
				<dd>
					<div class="prompt">
						您好，请<a href="">登录</a>
					</div>
					<div class="uclist mt10">
						<ul class="list1 fl">
							<li><a href="">用户信息></a></li>
							<li><a href="">我的订单></a></li>
							<li><a href="">收货地址></a></li>
							<li><a href="">我的收藏></a></li>
						</ul>

						<ul class="fl">
							<li><a href="">我的留言></a></li>
							<li><a href="">我的红包></a></li>
							<li><a href="">我的评论></a></li>
							<li><a href="">资金管理></a></li>
						</ul>

					</div>
					<div style="clear:both;"></div>
					<div class="viewlist mt10">
						<h3>最近浏览的商品：</h3>
						<ul>
							<li><a href=""><img src="__HOME__/images/view_list1.jpg" alt="" /></a></li>
							<li><a href=""><img src="__HOME__/images/view_list2.jpg" alt="" /></a></li>
							<li><a href=""><img src="__HOME__/images/view_list3.jpg" alt="" /></a></li>
						</ul>
					</div>
				</dd>
			</dl>
		</div>
		<!-- 用户中心 end-->

		<!-- 购物车 start -->
		<div class="cart fl">
			<dl>
				<dt>
					<a href="<?php echo url('cart/index'); ?>">去购物车结算</a>
					<b></b>
				</dt>
				<dd>
					<div class="prompt">
						购物车中还没有商品，赶紧选购吧！
					</div>
				</dd>
			</dl>
		</div>
		<!-- 购物车 end -->
	</div>
	<!-- 头部上半部分 end -->
	
	<div style="clear:both;"></div>

	<!-- 导航条部分 start -->
	<div class="nav w1210 bc mt10">
		<!--  商品分类部分 start-->
		<div class="category fl <?php if(empty($is_show) || (($is_show instanceof \think\Collection || $is_show instanceof \think\Paginator ) && $is_show->isEmpty())): ?> cat1<?php endif; ?>"> <!-- 非首页，需要添加cat1类 -->
			<div class="cat_hd <?php if(empty($is_show) || (($is_show instanceof \think\Collection || $is_show instanceof \think\Paginator ) && $is_show->isEmpty())): ?> off<?php endif; ?>" >  <!-- 注意，首页在此div上只需要添加cat_hd类，非首页，默认收缩分类时添加上off类，鼠标滑过时展开菜单则将off类换成on类 -->
				<h2>全部商品分类</h2>
				<em></em>
		</div>
			
			<div class="cat_bd <?php if(empty($is_show) || (($is_show instanceof \think\Collection || $is_show instanceof \think\Paginator ) && $is_show->isEmpty())): ?>none<?php endif; ?>">
			<?php if(is_array($category) || $category instanceof \think\Collection || $category instanceof \think\Paginator): $i = 0; $__LIST__ = $category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v1): $mod = ($i % 2 );++$i;if($v1['parent_id'] == '0'): ?>
				<div class="cat item1">
					<h3><a href=""><?php echo $v1['cname']; ?></a> <b></b></h3>
					<div class="cat_detail">
					<?php if(is_array($category) || $category instanceof \think\Collection || $category instanceof \think\Paginator): $i = 0; $__LIST__ = $category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v2): $mod = ($i % 2 );++$i;if($v2['parent_id'] == $v1['id']): ?>
						<dl class="dl_1st">
							<dt><a href=""><?php echo $v2['cname']; ?></a></dt>
							<?php if(is_array($category) || $category instanceof \think\Collection || $category instanceof \think\Paginator): $i = 0; $__LIST__ = $category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v3): $mod = ($i % 2 );++$i;if($v3['parent_id'] == $v2['id']): ?>
							<dd>
								<a href=""><?php echo $v3['cname']; ?></a>					
							</dd>
							<?php endif; endforeach; endif; else: echo "" ;endif; ?>
						</dl>
					<?php endif; endforeach; endif; else: echo "" ;endif; ?>
					</div>
				</div>
			<?php endif; endforeach; endif; else: echo "" ;endif; ?>
		    </div>
	</div>
		<!--  商品分类部分 end--> 
		
		<div class="navitems fl">
			<ul class="fl">
				<li class="current"><a href="">首页</a></li>
				<li><a href="">电脑频道</a></li>
				<li><a href="">家用电器</a></li>
				<li><a href="">品牌大全</a></li>
				<li><a href="">团购</a></li>
				<li><a href="">积分商城</a></li>
				<li><a href="">夺宝奇兵</a></li>
			</ul>
			<div class="right_corner fl"></div>
		</div>
	</div>
	<!-- 导航条部分 end -->
</div>
<!-- 头部 end-->

 <script type="text/javascript">
 	function quit(){
 		$.ajax({
 			type:'post',
 			url:"<?php echo url('index/quit'); ?>",
 			success:function(data){
 				location.reload(); // 刷新
 			}
 		})
 	}
 		
 
 </script>
<div style="clear:both;"></div>
	
	<!-- 页面主体 start -->
	<div class="main w1210 bc mt10">
		<div class="crumb w1210">
			<h2><strong>我的XX </strong><span>> 我的订单</span></h2>
		</div>
		
		<!-- 左侧导航菜单 start -->
		<div class="menu fl">
			<h3>我的XX</h3>
			<div class="menu_wrap">
				<dl>
					<dt>订单中心 <b></b></dt>
					<dd class="cur"><b>.</b><a href="">我的订单</a></dd>
					<dd><b>.</b><a href="">我的关注</a></dd>
					<dd><b>.</b><a href="">浏览历史</a></dd>
					<dd><b>.</b><a href="">我的团购</a></dd>
				</dl>

				<dl>
					<dt>账户中心 <b></b></dt>
					<dd><b>.</b><a href="">账户信息</a></dd>
					<dd><b>.</b><a href="">账户余额</a></dd>
					<dd><b>.</b><a href="">消费记录</a></dd>
					<dd><b>.</b><a href="">我的积分</a></dd>
					<dd><b>.</b><a href="">收货地址</a></dd>
				</dl>

				<dl>
					<dt>订单中心 <b></b></dt>
					<dd><b>.</b><a href="">返修/退换货</a></dd>
					<dd><b>.</b><a href="">取消订单记录</a></dd>
					<dd><b>.</b><a href="">我的投诉</a></dd>
				</dl>
			</div>
		</div>
		<!-- 左侧导航菜单 end -->

		<!-- 右侧内容区域 start -->
		<div class="content fl ml10">
			<div class="order_hd">
				<h3>我的订单</h3>
				<dl>
					<dt>便利提醒：</dt>
					<dd>待付款（0）</dd>
					<dd>待确认收货（0）</dd>
					<dd>待自提（0）</dd>
				</dl>

				<dl>
					<dt>特色服务：</dt>
					<dd><a href="">我的预约</a></dd>
					<dd><a href="">夺宝箱</a></dd>
				</dl>
			</div>

			<div class="order_bd mt10">
				<table class="orders">
					<thead>
						<tr>
							<th width="10%">时间</th>
							<th width="20%">物流信息</th>
						</tr>
					</thead>
					<tbody>
						<?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
						<tr>
							<td><a href=""><?php echo $vo['datetime']; ?></a></td>
							<td><?php echo $vo['remark']; ?></td>
						</tr>
						<?php endforeach; endif; else: echo "" ;endif; ?>
					</tbody> 
				</table>
			</div>
		</div>
		<!-- 右侧内容区域 end -->
	</div>
	<!-- 页面主体 end-->

	<div style="clear:both;"></div>
	<div style="clear:both;"></div>
<!-- 底部导航 start -->
<div class="bottomnav w1210 bc mt10">
	<div class="bnav1">
		<h3><b></b> <em>购物指南</em></h3>
		<ul>
			<li><a href="">购物流程</a></li>
			<li><a href="">会员介绍</a></li>
			<li><a href="">团购/机票/充值/点卡</a></li>
			<li><a href="">常见问题</a></li>
			<li><a href="">大家电</a></li>
			<li><a href="">联系客服</a></li>
		</ul>
	</div>
	
	<div class="bnav2">
		<h3><b></b> <em>配送方式</em></h3>
		<ul>
			<li><a href="">上门自提</a></li>
			<li><a href="">快速运输</a></li>
			<li><a href="">特快专递（EMS）</a></li>
			<li><a href="">如何送礼</a></li>
			<li><a href="">海外购物</a></li>
		</ul>
	</div>

	
	<div class="bnav3">
		<h3><b></b> <em>支付方式</em></h3>
		<ul>
			<li><a href="">货到付款</a></li>
			<li><a href="">在线支付</a></li>
			<li><a href="">分期付款</a></li>
			<li><a href="">邮局汇款</a></li>
			<li><a href="">公司转账</a></li>
		</ul>
	</div>

	<div class="bnav4">
		<h3><b></b> <em>售后服务</em></h3>
		<ul>
			<li><a href="">退换货政策</a></li>
			<li><a href="">退换货流程</a></li>
			<li><a href="">价格保护</a></li>
			<li><a href="">退款说明</a></li>
			<li><a href="">返修/退换货</a></li>
			<li><a href="">退款申请</a></li>
		</ul>
	</div>

	<div class="bnav5">
		<h3><b></b> <em>特色服务</em></h3>
		<ul>
			<li><a href="">夺宝岛</a></li>
			<li><a href="">DIY装机</a></li>
			<li><a href="">延保服务</a></li>
			<li><a href="">家电下乡</a></li>
			<li><a href="">京东礼品卡</a></li>
			<li><a href="">能效补贴</a></li>
		</ul>
	</div>
</div>
<!-- 底部导航 end -->

<div style="clear:both;"></div>
<!-- 底部版权 start -->
<div class="footer w1210 bc mt10">
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
</html>