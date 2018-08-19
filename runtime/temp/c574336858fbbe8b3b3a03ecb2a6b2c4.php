<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:59:"D:\Szshop\public/../application/admin\view\goods\index.html";i:1534074912;s:59:"D:\Szshop\public/../application/admin\view\public\base.html";i:1531729919;}*/ ?>
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
        <!-- 分类 -->
        <select name="cate_id">
            <option value="0">所有分类</option>
            <?php if(is_array($tree) || $tree instanceof \think\Collection || $tree instanceof \think\Paginator): $i = 0; $__LIST__ = $tree;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <option  value="<?php echo $vo['id']; ?>" <?php if($info['cate_id'] == $vo['id']): ?>selected="selected" <?php endif; ?>><?php echo str_repeat('*',$vo['lev']); ?><?php echo $vo['cname']; ?></option>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </select>

        <!-- 推荐 -->
        <select name="intro_type">
            <option value="0">全部</option>
            <option value="is_rec" <?php if($info['intro_type'] == 'is_rec'): ?>selected="selected"<?php endif; ?>>推荐</option>
            <option value="is_new" <?php if($info['intro_type'] == 'is_new'): ?>selected="selected"<?php endif; ?>>新品</option>
            <option value="is_hot" <?php if($info['intro_type'] == 'is_hot'): ?>selected="selected"<?php endif; ?>>热销</option>
        </select>
        <!-- 上架 -->
        <select name="is_sale">
            <option value='0'>全部</option>
            <option value="1" <?php if($info['is_sale'] == '1'): ?>selected="selected"<?php endif; ?>>上架</option>
            <option value="2" <?php if($info['is_sale'] == '2'): ?>selected="selected"<?php endif; ?>>下架</option>
        </select>
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
                <th>商品名称</th>
                <th>所属分类</th>
                <th>货号</th>
                <th>价格</th>
                <th>上架</th>
                <th>推荐</th>
                <th>新品</th>
                <th>热销</th>
                <th>操作</th>
                <th>编辑库存</th>
            </tr>
            <?php if(is_array($goodsData) || $goodsData instanceof \think\Collection || $goodsData instanceof \think\Paginator): $i = 0; $__LIST__ = $goodsData;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <tr>
                <td align="center"><?php echo $vo['id']; ?></td>
                <td align="center" class="first-cell"><span><?php echo $vo['goods_name']; ?></span></td>
                <td align="center" class="first-cell"><span><?php echo $vo['cname']; ?></span></td>
                <td align="center"><span onclick=""><?php echo $vo['goods_sn']; ?></span></td>
                <td align="center"><span><?php echo $vo['shop_price']; ?></span></td>
                <td align="center"><img onclick="is_toggle(this,<?php echo $vo['id']; ?>,'is_sale')" src="__ADMIN__/Images/<?php if($vo['is_sale'] == '1'): ?>yes<?php else: ?>no<?php endif; ?>.gif "/></td>
                <td align="center"><img onclick="is_toggle(this,<?php echo $vo['id']; ?>,'is_rec')" src="__ADMIN__/Images/<?php if($vo['is_rec'] == '1'): ?>yes<?php else: ?>no<?php endif; ?>.gif "/></td>
                <td align="center"><img onclick="is_toggle(this,<?php echo $vo['id']; ?>,'is_new')" src="__ADMIN__/Images/<?php if($vo['is_new'] == '1'): ?>yes<?php else: ?>no<?php endif; ?>.gif "/></td>
                <td align="center"><img onclick="is_toggle(this,<?php echo $vo['id']; ?>,'is_hot')" src="__ADMIN__/Images/<?php if($vo['is_hot'] == '1'): ?>yes<?php else: ?>no<?php endif; ?>.gif "/></td>
                <td align="center">
                <a href="<?php echo url('edit','id='.$vo['id']); ?>" title="编辑"><img src="__ADMIN__/Images/icon_edit.gif" width="16" height="16" border="0" /></a>
                <a href="<?php echo url('del','id='.$vo['id']); ?>" onclick="" title="回收站"><img src="__ADMIN__/Images/icon_trash.gif" width="16" height="16" border="0" /></a></td>
               <td align="center">
               <a href="<?php echo url('sku/add','id='.$vo['id']); ?>" title="编辑">
               <img src="__ADMIN__/Images/icon_edit.gif "/></a>
               </td>
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
                    <?php echo $goodsData -> render(); ?>
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

    <script type="text/javascript">
        // 实现状态切换
        function is_toggle(obj,goods_id,field)
        {
            $.ajax({
                type:'post',
                url:"<?php echo url('setStatus'); ?>",
                data:{goods_id:goods_id,field:field},
                success:function(data)
                {
                    if(data.statusCode == 0)
                    {
                        alert('fail');
                    }
                    // 正常处理
                    if(data.status == 1)
                    {
                        $(obj).attr('src','__ADMIN__/Images/yes.gif');
                    }else{
                        $(obj).attr('src','__ADMIN__/Images/no.gif');
                    }
                }
            })
        }
    </script>
