<?php 
namespace app\admin\controller;
use think\Controller;
use think\Db;
// 库存控制器
class Sku extends Controller
{ 
	public function add()
	{
		$goods_id = input('id');
		// get请求渲染模板
   	    if($this -> request -> isGet())
   	    {
   	   		$attr = Db::name('goods_attr')->alias('a')->Field('a.*,b.attr_type,b.attr_name')->join('shop_attribute b','a.attr_id=b.id','left')->where('a.goods_id',$goods_id)->select(); 
   	   		$list = [];
   	   		foreach ($attr as $key => $value) {
   	   			if ($value['attr_type'] == 2) {
   	   				$list[$value['attr_id']][] = $value;
   	   			}	
   	   		}
   	   			
   	   		$this -> assign('list',$list);
   	   		$goods_name = Db::name('goods')->field('goods_name')->find($goods_id);
   	   		$this -> assign('goods_name',$goods_name);//dump($goods_name);exit;
   	   		return $this -> fetch();
   	    }
   	    $result = model('sku') -> addSku();
   	    if ($result === false) {
   	    	$this -> error('添加失败');
   	    }
   	    $this -> success('添加成功','goods/index');
	}

}