<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:55:"D:\Szshop\public/../application/admin\view\sku\add.html";i:1532759684;s:59:"D:\Szshop\public/../application/admin\view\public\base.html";i:1531729919;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 添加分类 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="__ADMIN__/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="__ADMIN__/Styles/main.css" rel="stylesheet" type="text/css" />
</head>
<body>

<h1>
    <span class="action-span"><a href="#">商品分类</a></span>
    <span class="action-span1"><a href="#">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 添加分类 </span>
    <div style="clear:both"></div>
</h1>



<div class="main-div">
    <form action="" method="post" name="theForm" enctype="multipart/form-data">
        <table width="100%" id="general-table">
            <tr >
                <?php if(is_array($goods_name) || $goods_name instanceof \think\Collection || $goods_name instanceof \think\Paginator): $i = 0; $__LIST__ = $goods_name;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <td class="label" ><?php echo $vo; ?></td>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </tr>

            <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <tr>
                <dl>
                    <dt><?php echo $vo['0']['attr_name']; ?></dt>
                    <dd>
                    <?php if(is_array($vo) || $vo instanceof \think\Collection || $vo instanceof \think\Paginator): $keys = 0; $__LIST__ = $vo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($keys % 2 );++$keys;?>
                        <?php echo $v['attr_value']; ?><input type="radio" name="attr[<?php echo $v['attr_id']; ?>]" value="<?php echo $v['id']; ?>" <?php if($keys == '1'): ?>checked="checked"<?php endif; ?> /></a>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                        <input type="hidden" name="" value="" />
                    </dd>
                </dl>
            </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            <tr>
                <td>
                   价格 <input type="text" name="price"></input>
                </td>
            </tr>
            <tr>
                <td>
                   库存 <input type="text" name="sku_num"></input>
                </td>
            </tr>
        </table>
        <div class="button-div">
            <input type="submit" value=" 确定 " />
            <input type="reset" value=" 重置 " />
        </div>
    </form>
</div>


<div id="footer">
共执行 3 个查询，用时 0.162348 秒，Gzip 已禁用，内存占用 2.266 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>

</body>
</html>
<script type="text/javascript" src="__ADMIN__/Js/jquery-1.8.3.min.js"></script>
