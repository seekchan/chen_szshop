<?php 
namespace app\admin\controller;
use think\Db;
use think\Model;
/**
* 属性控制器
*/
class Attribute extends Common
{
	// 商品属性添加
	public function add()
	{
		if($this -> request -> isGet())
		{	
			$type = get_type_info();
			$this -> assign('type',$type);	
			return $this -> fetch();
		}
		$data = input();
		$validate = $this -> validate($data,'attribute'); 
		if($validate !== true)
		{
			$this -> error($validate);
		}
		// 判断type_id不能为 0
		if(!$data['type_id'])
		{
			$this -> error('请选择分类');
		}
		// 判断属性值录入方式
		if($data['attr_input_type'] == 1)
		{
			unset($data['attr_values']);
		}else{
			if(!$data['attr_values'])
			{
				$this -> error('点击单选时,默认值不能为空');
			}
		}
		$result = Db::name('attribute') -> insert($data);
		if($result === false)
		{
			$this -> error('添加失败');
		}
		$this -> success('添加成功');
	}

	// 商品属性首页界面
	public function index()
	{
		$model = model('attribute');
		$attr = $model -> listAttr();
		if($attr === false)
		{
			$this -> error($model -> getError());
		}
		$this -> assign('attr',$attr);
		return $this -> fetch();
	}

	// 商品属性删除
	public function del()
	{
		$attr_id = input('id');
		$result = Db::name('attribute') -> where('id',$attr_id) -> delete();
		if($result === false)
		{
			$this -> error('删除失败');
		}
		$this -> success('删除成功');
	}

	// 商品属性编辑
	public function edit()
	{
		$data = input();
		if($this -> request -> isGet())
		{	
			$type = get_type_info();
			$this -> assign('type',$type);
			$attr = Db::name('attribute') -> find($data['id']);
			$this -> assign('attr',$attr);
			return $this -> fetch();
		}	
		$validate = $this -> validate($data,'attribute'); 
		if($validate !== true)
		{
			$this -> error($validate);
		}
		// 判断type_id不能为 0
		if(!$data['type_id'])
		{
			$this -> error('请选择分类');
		}
		// 判断属性值录入方式
		if($data['attr_input_type'] == 1)
		{
			unset($data['attr_values']);
		}else{
			if(!$data['attr_values'])
			{
				$this -> error('点击单选时,默认值不能为空');
			}
		}
		$result = Db::name('attribute') -> where('id',$data['id']) -> update($data);
		if($result === false)
		{
			$this -> error('修改失败');
		}
		$this -> success('修改成功');
	}
}

?>