<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:59:"D:\Szshop\public/../application/admin\view\order\index.html";i:1533123048;s:59:"D:\Szshop\public/../application/admin\view\public\base.html";i:1531729919;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 商品首页 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="__ADMIN__/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="__ADMIN__/Styles/main.css" rel="stylesheet" type="text/css" />
</head>
<body>

<h1>
    <span class="action-span"><a href="">添加新商品</a></span>
    <span class="action-span1"><a href="">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 商品列表 </span>
    <div style="clear:both"></div>
</h1>



<div class="form-div">
    <form action="" name="searchForm">
        <img src="__ADMIN__/Images/icon_search.gif" width="26" height="22" border="0" alt="search" />
        <!-- 关键字 -->
        关键字 <input type="text" name="keyword" size="15" />
        <input type="submit" value=" 搜索 " class="button" />
    </form>
</div>

<!-- 商品列表 -->

    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <th>编号</th>
                <th>订单号</th>
                <th>收货人</th>
                <th>金额</th>
                <th>支付方式</th>
                <th>支付状态</th>
                <th>操作</th>
            </tr>
            <?php if(is_array($order) || $order instanceof \think\Collection || $order instanceof \think\Paginator): $i = 0; $__LIST__ = $order;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <tr>
                <td align="center"><?php echo $vo['id']; ?></td>
                <td align="center" class="first-cell"><span><?php echo $vo['order_id']; ?></span></td>
                <td align="center" class="first-cell"><span><?php echo $vo['consignee']; ?></span></td>
                <td align="center"><span><?php echo $vo['money']; ?></span></td>
                <?php if($vo['pay'] == 1): ?>
                <td align="center"><span>支付宝</span></td>
                <?php elseif($vo['pay'] == 2): ?>
                <td align="center"><span>微信</span></td>
                <?php else: ?>
                <td align="center"><span>银行卡</span></td>
                <?php endif; if($vo['status'] == 0): ?>
                <td align="center"><span>已下单</span></td>
                <?php elseif($vo['status'] == 1): ?>
                <td align="center"><span>已支付</span></td>
                <?php else: ?>
                <td align="center"><span>已发货</span></td>
                <?php endif; if($vo['status'] == '1'): ?>
                <td align="center">
                <a href="<?php echo url('send','id='.$vo['id']); ?>" title="发货"><img src="__ADMIN__/Images/icon_edit.gif" width="16" height="16" border="0" /></a>
               </td>
               <?php endif; ?>
            </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </table>
        <style>
            .pagination li{float: left;list-style-type: none;margin:0 10px;}
        </style>
        <!-- 分页开始 -->
        <table id="page-table" cellspacing="0">
            <tr>
                <td width="80%">&nbsp;</td>
                <td align="center" nowrap="true">
                    <?php echo $order -> render(); ?>
                </td>
            </tr>
        </table>
    <!-- 分页结束 -->
    </div>


<div id="footer">
共执行 3 个查询，用时 0.162348 秒，Gzip 已禁用，内存占用 2.266 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>

</body>
</html>
<script type="text/javascript" src="__ADMIN__/Js/jquery-1.8.3.min.js"></script>
