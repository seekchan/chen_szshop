<?php 
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Model;
// 权限控制器
class Privilege extends Controller
{  
	// 显示分类添加页面 
	public function add()
	{       
    // get请求渲染模板
	   if($this -> request -> isGet())
	   {	
           $privilege = model('privilege') -> getPri();
           $this -> assign('privilege',$privilege);
	   	  return $this -> fetch();
	   }
	   // 接受数据
	  	$data = input();                      //var_dump($data);exit;  		
	  	// 数据入库
	  	$result = Db::name('privilege')->insert($data);
	  	if($result===false)
	  	{
     	   $this ->error('骚年,腻西败了');
	  	}
	   $this -> success('不错喲,骚年!');            
	}

   // 权限界面显示
   public function index()
      {
         //调用模型方法获取数据
         $privilege = model('privilege') -> getPri();
         $data = $this -> assign('privilege',$privilege);
         return $this -> fetch();
      }

   // 删除权限
   public function del()
   {
      //获取数据
      $privilege_id = input('id',0);
      //调用模型方法执行删除
      $result = Db::name('privilege') -> where('id','=',$privilege_id) -> delete();
      if(!$result)
      {
         $this -> error('删除失败');
      }
      $this -> success('不错喲,骚年!');
   }

   // 编辑权限
   public function edit()
   {   
      $id = input('id',0);   
      // get请求渲染模板
      if($this -> request -> isGet())
      {  
         $info = Db::name('privilege') -> find($id); //dump($info);exit;
         $this -> assign('info',$info);
         $privilege = model('privilege') -> getPri();
         $this -> assign('privilege',$privilege); 
         return $this -> fetch();
      }    
      // 数据入库
      $result = model('privilege') -> edit();
      if($result===false)
      {
         $this ->error('骚年,腻西败了');
      }
      $this -> success('不错喲,骚年!','index');            
   }
    
}