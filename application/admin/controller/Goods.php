<?php 
namespace app\admin\controller;
use think\Controller;
use think\Model;
use think\Db;

/*
商品控制器
*/
class Goods extends Common
{
	// 商品添加
	public function add()
	{   
		// 显示添加界面
		if($this -> request -> isGet())
		{   
			$tree = Model('category') -> getCateTree();
			$this -> assign('tree',$tree);
			$type = get_type_info();
			$this -> assign('type',$type);
			return view();
		}

		// 添加入库   
		$model = model('goods');
		$result = $model -> addGoods();
		if($result === false)
		{
			$this -> error($model -> getError(),'goods/add');
		}
		$this -> success('添加成功','goods/add');
	}

	// 添加时属性触发的ajax
	public function showAttr()
	{
		$type_id = input('type_id',0,'intval'); 
		if($type_id <= 0)
		{
			$this -> error('请选择类型');
		}
		$attr = model('attribute') -> getTypeAttr($type_id);
		$this -> assign('attr',$attr); 
		return $this -> fetch();
	}

	// 商品显示
	public function index()
	{
		// 获取分类数据
		$tree = model('category') -> getCateTree();
		$this ->assign('tree',$tree);
		// 获取商品数据
		$goodsData = model('goods') -> listGoods(); 
		// dump($goodsData);exit;
		$this -> assign('goodsData',$goodsData);
		// 获取前端传过来的cate_id
		$info = input(); 
		$info['page']=isset($info['page'])?$info['page']:1;
		$info['cate_id']=isset($info['cate_id'])?$info['cate_id']:0;
		$info['intro_type']=isset($info['intro_type'])?$info['intro_type']:1;
		$info['is_sale']=isset($info['is_sale'])?$info['is_sale']:0;
        $this -> assign('info',$info);  
		return $this -> fetch();		
	}

	// 商品伪删除
	public function del(){
		$model = model('goods');
		$id = input('id'); 	 
		$result = $model -> where('id','=',$id) -> setField('is_del',1);
		if($result === false)
		{
			$this -> error($model -> getError());
		}
		$this -> success('删除成功');
	}

	// 商品还原
	public function rollback(){
		$model = model('goods');
		$id = input('id'); 	 
		$result = $model -> where('id','=',$id) -> setField('is_del',0);
		if($result === false)
		{
			$this -> error($model -> getError());
		}
		$this -> success('还原成功');
	}

	// 商品彻底删除
	public function remove(){
		$model = model('goods');
		$id = input('id'); 	 
		$result = $model -> where('id','=',$id) -> delete();
		if($result === false)
		{
			$this -> error($model -> getError());
		}
		$this -> success('删除成功','recycle');
	}

	// 回收站显示
	public function recycle()
	{
		// 获取分类数据
		$tree = model('category') -> getCateTree();
		$this ->assign('tree',$tree);
		// 获取商品数据
		$goodsData = model('goods') -> listGoods(1); 
		//dump($goodsData);exit;
		$this -> assign('goodsData',$goodsData);
		// 获取前端传过来的cate_id
		$info = input(); 
		$info['page']=isset($info['page'])?$info['page']:1;
		$info['cate_id']=isset($info['cate_id'])?$info['cate_id']:0;
		$info['intro_type']=isset($info['intro_type'])?$info['intro_type']:1;
		$info['is_sale']=isset($info['is_sale'])?$info['is_sale']:0;
        $this -> assign('info',$info);  
		return $this -> fetch();		
	}

	// 商品编辑
	public function edit(){
		$model = model('goods');
		$goods_id = input('id');
		// 编辑界面回显
		if($this -> request -> isGet()){
			$tree = model('category') -> getCateTree();
			$this -> assign('tree',$tree);
			$info = $model -> get($goods_id);
			$this -> assign('info',$info); // dump($info);exit;
			// 属性框数据
			$type = get_type_info();
			$this -> assign('type',$type); // dump($type);exit;  
			$attr = model('GoodsAttr') -> get_attr_value($goods_id);
			$this -> assign('attr',$attr);   // dump($attr);exit;
			$img = Db::name('goods_img') -> where('goods_id','=',$goods_id) -> select();
			$this -> assign('img',$img);
			return $this -> fetch();
		}
		// 编辑商品内容
		$result = $model -> edit();
		if($result == false)
		{
			$this -> error($model -> getError());
		}
		$this -> success('修改成功','index');
	}

	public function delImg()
	{
		$img_id = input('img_id/d',0);// dump($img_id);exit;
		Db::name('goods_img') -> where('id','=',$img_id) -> delete();
		return json(['status'=>1]);
	}

	// 处理ajax切换状态
	public function setStatus()
	{
		// 接收需要修改的商品标识
		$goods_id = input('goods_id/d');
		// 要修改的字段
		$field = input('field');
		$model = model('goods');
		$result = $model -> setStatus($goods_id,$field);
		if($result === false)
		{
			return json(['statusCode' => '0', 'msg' => $model -> getError()]);
		}
		return json(['statusCode' => 1,'msg' => 'ok','status' => $result]);
	}


}

?>