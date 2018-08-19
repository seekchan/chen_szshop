<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:57:"D:\Szshop\public/../application/admin\view\goods\add.html";i:1533784974;s:59:"D:\Szshop\public/../application/admin\view\public\base.html";i:1531729919;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 商品添加 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="__ADMIN__/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="__ADMIN__/Styles/main.css" rel="stylesheet" type="text/css" />
</head>
<body>

<h1>
    <span class="action-span"><a href="#">商品分类</a></span>
    <span class="action-span1"><a href="#">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 增加新商品 </span>
    <div style="clear:both"></div>
</h1>



    <div id="tabbar-div">
        <p>
            <span class="tab-front" >通用信息</span>
            <span class="tab-front" >详细描述</span>
            <span class="tab-front" >商品属性</span>
            <span class="tab-front" >商品相册</span>
        </p>
    </div>
    <div id="tabbody-div">
        <form enctype="multipart/form-data" action="" method="post">
            <table width="90%" class="table" align="center">
                <tr>
                    <td class="label">商品名称：</td>
                    <td><input type="text" name="goods_name" value=""size="30" />
                    <span class="require-field">*</span></td>
                </tr>
                <tr>
                    <td class="label">商品货号： </td>
                    <td>
                        <input type="text" name="goods_sn" value="" size="20"/>
                        <span id="goods_sn_notice"></span><br />
                        <span class="notice-span"id="noticeGoodsSN">如果您不输入商品货号，系统将自动生成一个唯一的货号。</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">总库存: </td>
                    <td>
                        <input type="text" name="goods_number" value="" />
                    </td>
                </tr>
                <tr>
                    <td class="label">商品分类：</td>
                    <td>
                        <select name="cate_id">
                            <option value="0">请选择...</option>
                            <?php if(is_array($tree) || $tree instanceof \think\Collection || $tree instanceof \think\Paginator): $i = 0; $__LIST__ = $tree;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            <option value="<?php echo $vo['id']; ?>"><?php echo str_repeat("--",$vo['lev']); ?><?php echo $vo['cname']; ?></option>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                        <span class="require-field">*</span>
                    </td>
                </tr>

                <tr>
                    <td class="label">本店售价：</td>
                    <td>
                        <input type="text" name="shop_price" value="" size="20"/>
                        <span class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">是否上架：</td>
                    <td>
                        <input type="radio" name="is_sale" value="1" checked="checked" /> 是
                        <input type="radio" name="is_sale" value="0"/> 否
                    </td>
                </tr>
                <tr>
                    <td class="label">加入推荐：</td>
                    <td>
                        <input type="checkbox" name="is_hot" value="1" /> 热卖 
                        <input type="checkbox" name="is_new" value="1" /> 新品 
                        <input type="checkbox" name="is_rec" value="1" /> 推荐
                    </td>
                </tr>

                <tr>
                    <td class="label">市场售价：</td>
                    <td>
                        <input type="text" name="market_price" value="" size="20" />
                    </td>
                </tr>

                <tr>
                    <td class="label">商品图片：</td>
                    <td>
                        <input type="file" name="goods_img" size="35" />
                    </td>
                </tr>
                
            </table>
            <table width="90%" class="table" align="center" style="display: none">
                <tr>
                    <td class="label">商品描述：</td>
                    <td>
                       <!-- 加载编辑器的容器 -->
                        <script id="container" name="goods_body" type="text/plain" style="min-height: 300px; width: 1100px" >
                        </script>
                        <!-- 配置文件 -->
                        <script type="text/javascript" src="__STATIC__/ueditor/ueditor.config.js"></script>
                        <!-- 编辑器源码文件 -->
                        <script type="text/javascript" src="__STATIC__/ueditor/ueditor.all.js"></script>
                        <!-- 实例化编辑器 -->
                        <script type="text/javascript">
                            var ue = UE.getEditor('container');
                        </script>
                    </td>
                </tr>
            </table>
            <table width="90%" class="table" align="center" style="display: none">
                <tr>
                    <td class="label">选择类型：</td>
                    <td>
                        <select name="type_id" id="type_id">
                        <option value="0">选择分类</option>
                        <?php if(is_array($type) || $type instanceof \think\Collection || $type instanceof \think\Paginator): $i = 0; $__LIST__ = $type;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <option value="<?php echo $vo['id']; ?>">
                            <?php echo $vo['type_name']; ?>
                        </option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </td>
                </tr>
                <tr>
                    <td class="label" id="showAttr" colspan="2"></td>
                </tr>
            </table>
            <table width="90%" class="table pic" align="center" style="display:none">
                <tr>
                    <td class="label">
                        <input type="button" value="添加相册" id="addPic" name="pic[]" />
                    </td>
                </tr>
                <tr>
                    <td class="label">相册图片：</td>
                    <td>
                    <input type="file" name="pic[]" />
                    </td>
                </tr>
            </table>
            <div class="button-div">
                <input type="submit" value=" 确定 " class="button"/>
                <input type="reset" value=" 重置 " class="button" />
            </div>
        </form>
    </div>


<div id="footer">
共执行 3 个查询，用时 0.162348 秒，Gzip 已禁用，内存占用 2.266 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>

</body>
</html>
<script type="text/javascript" src="__ADMIN__/Js/jquery-1.8.3.min.js"></script>

<script type="text/javascript" src="__ADMIN__/Js/jquery-1.8.3.min.js"></script>
<script type="text/javascript">
    // 选项卡
    $('#tabbar-div p span').click(function(){
        // 判断当前点击的索引
        var index = $(this).index();
        // 隐藏所有的table
        $('.table').hide();
        // 显示当前点击选项卡对应的table
        $('.table').eq(index).show();
    });

    // 属性值点击事件
    $('#type_id').change(function(){
        // 获取到当前选中的类型的id
        var type_id = $(this).val();
        $.ajax({
            url:'<?php echo url("showAttr"); ?>',
            data:{type_id:type_id},
            type:'post',
            success:function(msg){
                // 规定返回数据为html字符串格式 返回数据时已经组装成为了最终需要的html格式
                $('#showAttr').html(msg);
            }
        });
    });

    // 点击[+]事件
    function clonethis(obj)
    {
        // 获取到当前点击的对应的tr对象
        var Tr = $(obj).parent().parent();
        if($(obj).html()=='[+]')
        {
            var newtr = Tr.clone();
            // 将复制的内容中的+符号换成-
            newtr.find('a').html('[-]');
            Tr.after(newtr);
        }else{
            Tr.remove();
        }
    }

    // 添加相册点击事件
    $('#addPic').click(function(){
        var obj = $(this).parent().parent().next().clone();
        $('.pic').append(obj);
    });
</script>
