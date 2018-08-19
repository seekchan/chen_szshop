<?php 
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Model;

// 角色控制器
class Admin extends Controller
{  
	// 显示角色添加页面 
   	public function add()
   	{       
       // get请求渲染模板
   	   if($this -> request -> isGet())
   	   {	
   	   		$role = Db::name('role') -> where('id','>',1) -> select();
   	   		$this -> assign('role',$role);
   	   		return $this -> fetch();
   	   }
   	   $user = Db::name('admin') ->where('username','=',input('username')) -> find(); 
   	   if ($user) {
   	   	  $this -> error('用户名已存在');
   	   }
   	   if (input('role_id') == 0) {
   	   	  $this -> error('请选择管理员');	
   	   }
   	   $model = model('admin');
   	   $result = $model -> addUser();
   	   if($result === false){
   	   		$this ->error('添加失败','add');
   	   }
   	   $this -> success('添加成功','index');
   	}

   	// 管理员界面显示
   	public function index()
   	{
   		$data = model('admin') -> listAdmin();
   		$this -> assign('data',$data);
   		return $this -> fetch();
   	}

   	// 编辑
   	public function edit()
   	{
   		
   		if($this -> request -> isGet())
   	   {	
   		  $role = Db::name('role') -> where('id','>',1) -> select();
   		  $this -> assign('role',$role);
   		  $info = model('admin') -> listEdit();
   		  $this -> assign('info',$info);
   		  return $this -> fetch();
   	   }
   	   $user = Db::name('admin') ->where('username','=',input('username')) -> find(); 
   	   if ($user) {
   	   	  $this -> error('用户名已存在');
   	   }
   	   if (input('role_id') == 0) {
   	   	  $this -> error('请选择管理员');	
   	   }
   	   $model = model('admin');
   	   $result = $model -> edit();
   	   if($result === false){
   	   		$this ->error('修改失败','edit');
   	   }
   	   $this -> success('修改成功','index');
   	}

   	// 用户角色删除
   	public function del()
   	{
	 	$admin_id = input('id/d',0);
        if($admin_id<=1){
       		$this ->error('参数出错');
        }
   		$result1 = Db::name('admin') -> where('id','=',$admin_id) -> delete();
   		$result2 = Db::name('admin_role') -> where('admin_id','=',$admin_id) -> delete();
   		if($result1 === false || $result2 === false){
   	   		$this ->error('删除失败');
   	   }
   	   $this -> success('删除成功','index');
   	}
}