<?php 
namespace app\admin\controller;
use think\Controller;
use think\Db;

// 角色控制器
class Role extends Controller
{  
	// 显示角色添加页面 
 	public function add()
 	{       
     // get请求渲染模板
 	   if($this -> request -> isGet())
 	   {	
 	   		return $this -> fetch();
 	   }
 	   $data = input();
 	   $result = Db::name('role') -> insert($data);
 	   if($result === false){
 	   		$this ->error('添加失败');
 	   }
 	   $this -> success('添加成功','index');
 	}

 	// 角色界面显示
 	public function index()
 	{
 		$role = Db::name('role') -> select();
 		$this -> assign('role',$role);
 		return $this -> fetch();
 	}

 	// 角色编辑
 		public function edit()
 	{      
     $role_id = input('id/d',0);
     if($role_id<=1){
     		$this ->error('参数出错');
     }
 	   if($this -> request -> isGet())
 	   {	
 	   		$role = Db::name('role') -> where('id','=',$role_id) -> find();
 			$this -> assign('role',$role);
 	   		return $this -> fetch();
 	   }
 	   $role_name = input();
 	   $result = Db::name('role') -> where('id','=',$role_id) -> update($role_name);
 	   if($result === false){
 	   		$this ->error('修改失败');
 	   }
 	   $this -> success('修改成功','index');
 	}

 	// 角色删除
 	public function del()
 	{
 	$role_id = input('id/d',0);
      if($role_id<=1){
     		$this ->error('参数出错');
      }
 		$result = Db::name('role') -> where('id','=',$role_id) -> delete();
 		if($result === false){
 	   		$this ->error('删除失败');
 	   }
 	   $this -> success('删除成功','index');
 	}

  // 权限分配
  public function disfetch()
  {
    $role_id = input('id/d',0); 
      if($this -> request -> isGet()){  
        $privilege = model('privilege') -> getPri();
        $this -> assign('privilege',$privilege);//dump($privilege);exit;
        $priData = Db::name('role_privilege') -> field('privilege_id') -> where('role_id','=',$role_id) -> select();//dump($priData);exit;
        $pri_id = [];
        foreach ($priData as $key => $value) {
          $pri_id[] = $value['privilege_id'];
        }//dump($pri_id);exit;
        $pri_id = implode(',', $pri_id);
        $this -> assign('pri_id',$pri_id);
      return $this -> fetch();
    }
    
    if ($role_id<=1) {
      $this->error('参数错误');
    }
    $list = [];
    $data = input('privilege/a'); //dump($data);exit;
    foreach ($data as $key => $value) {
      $list[] = ['role_id'=>$role_id,'privilege_id'=>$value];
    }//dump($list);exit;
    // 由于分配权限反复进行具备了修改功能
    Db::name('role_privilege') -> where('role_id','=',$role_id) -> delete();
    if($list){
      Db::name('role_privilege') -> insertAll($list); 
    }
    $this -> success('分配成功','index');
  }
}