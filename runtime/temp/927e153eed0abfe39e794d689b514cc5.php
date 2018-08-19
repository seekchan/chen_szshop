<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:58:"D:\Szshop\public/../application/index\view\user\login.html";i:1533380268;s:61:"D:\Szshop\public/../application/index\view\public\header.html";i:1534127400;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>登录商城</title>
	<link rel="stylesheet" href="__HOME__/style/base.css" type="text/css">
	<link rel="stylesheet" href="__HOME__/style/global.css" type="text/css">
	<link rel="stylesheet" href="__HOME__/style/header.css" type="text/css">
	<link rel="stylesheet" href="__HOME__/style/login.css" type="text/css">
	<link rel="stylesheet" href="__HOME__/style/footer.css" type="text/css">
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
	
	<!-- 登录主体部分start -->
	<div class="login w990 bc mt10">
		<div class="login_hd">
			<h2>用户登录</h2>
			<b></b>
		</div>
		<div class="login_bd">
			<div class="login_form fl">
				<form action="" method="post">
					<ul>
						<li>
							<label for="">用户名：</label>
							<input type="text" class="txt" name="username" />
						</li>
						<li>
							<label for="">密码：</label>
							<input type="password" class="txt" name="password" />
							<a href="">忘记密码?</a>
						</li>
						<li class="captcha">
							<label for="">验证码：</label>
							<input type="text"  name="captcha" />
							<img src="<?php echo url('captcha'); ?>" alt="" id="captcha"/>
							<span>看不清？<a href="" >换一张</a></span>
						</li>
						<li>
							<label for="">&nbsp;</label>
							<input type="checkbox" name="remember" class="chb" /> 保存登录信息
						</li>
						<li>
							<label for="">&nbsp;</label>
							<input type="submit" value="" class="login_btn" />
						</li>
					</ul>
				</form>

				<div class="coagent mt15">
					<dl>
						<dt>使用合作网站登录商城：</dt>
						<dd class="qq"><a href="" onclick="toQzoneLogin()"><span></span>QQ</a></dd>
						<dd class="weibo"><a href=""><span></span>新浪微博</a></dd>
						<dd class="yi"><a href=""><span></span>网易</a></dd>
						<dd class="renren"><a href=""><span></span>人人</a></dd>
						<dd class="qihu"><a href=""><span></span>奇虎360</a></dd>
						<dd class=""><a href=""><span></span>百度</a></dd>
						<dd class="douban"><a href=""><span></span>豆瓣</a></dd>
					</dl>
				</div>
			</div>
			
			<div class="guide fl">
				<h3>还不是商城用户</h3>
				<p>现在免费注册成为商城用户，便能立刻享受便宜又放心的购物乐趣，心动不如行动，赶紧加入吧!</p>

				<a href="regist.html" class="reg_btn">免费注册 >></a>
			</div>

		</div>
	</div>
	<!-- 登录主体部分end -->

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
<script type="text/javascript" src="__HOME__/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript">
	$('#captcha').click(function(){
		var src = "<?php echo url('captcha'); ?>?_t"+Math.random();
		$(this).attr('src',src);
	})

</script>
<script type="text/javascript">
    var childWindow;
    function toQzoneLogin()
    {
        childWindow = window.open("<?php echo url('oauth'); ?>","TencentLogin","width=450,height=320,menubar=0,scrollbars=1, resizable=1,status=1,titlebar=0,toolbar=0,location=1");
    } 
    
    function closeChildWindow()
    {
        childWindow.close();
    }
</script>
</html>