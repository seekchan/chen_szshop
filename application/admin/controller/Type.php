<?php 
namespace app\admin\controller;
use think\Db;
/**
*   类型控制器
*/
class Type extends Common
{
	// 类型添加
	public function add()
	{
		// 显示添加界面
		if($this -> request -> isGet())
		{
			return $this -> fetch();
		}
		$type_name = input('type_name');
		// 查找数据库里是否已经存在用户输入的类型
		$info = Db::name('type') -> where('type_name','=',$type_name) -> find(); 
		if($info)
		{
			$this -> error('该类型已存在');
		}
		// 添加入库
		$result = Db::name('type')->insert(['type_name' => $type_name]);
		if($result === false)
		{
			$this -> error('添加失败');
		}
		$this -> success('添加成功');
	}

	// 类型首页界面
	public function index()
	{	
		$type = Db::name('type')-> paginate(5);
		if($type === false)
		{
			$this -> error('添加失败');
		}
		$this -> assign('type',$type);
		return $this -> fetch();
	}

	// 类型删除
	public function del()
	{
		$type = Db::name('type') -> where('id','=',input('id')) -> delete();
		if($type === false)
		{
			$this -> error('删除失败');
		}		
		$this -> success('删除成功');
	}

	// 类型编辑
	public function edit()
	{
		// 显示添加界面
		if($this -> request -> isGet())
		{	
			$type = Db::name('type') -> where(['id' => input('id')]) -> find(); 
			$this -> assign('type',$type);
			return $this -> fetch();
		}
		
		// 编辑入库
		$result = Db::name('type') -> where(['id' => input('id')]) -> update(['type_name' => input('type_name')]);
		if($result === false)
		{
			$this -> error('修改失败');
		}
		$this -> success('修改成功','index');
	}
}

?>