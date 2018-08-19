<?php 
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Model;
//use think\Request;
// 分类控制器
class Category extends Controller
{  
   	// 显示分类添加页面 
   	public function add()
   	{       
       // get请求渲染模板
   	   if($this -> request -> isGet())
   	   {
   	   		// 使用模型对象调用自定义方法获取分类数据
   	   		$category = model('category') -> getCateTree(); 
   	   		$this -> assign('category',$category);		
   	   		return $this -> fetch();
   	   }
   	   // 接受数据
   	  	$data = input();                      //var_dump($data);exit;  		
   	  	// 数据入库
   	  	$result = Db::name('category')->insert($data);
   	  	if($result===false)
   	  	{
        	$this ->error('骚年,腻西败了');
   	  	}
   	    	$this -> success('不错喲,骚年!');            
   	}

    public function index()
    {
    	//调用模型方法获取数据
    	$category = model('category') -> getCateTree();
    	$data = $this -> assign('category',$category);
    	return $this -> fetch();
    }
    // 删除分类
    public function del()
    {
    	//获取所有数据
    	$cate_id = input('id',0);
    	//调用模型方法执行删除
    	$model = model('category');
    	$result = $model -> del($cate_id);
    	if(!$result)
    	{
    		$this -> error($model->getError(),'index');
    	}
    	$this -> success('不错喲,骚年!');
    }
    // 编辑分类
    public function edit()
    {
      $model = model('category');
      // 编辑界面
      if($this -> request -> isGet())
      {
        $info = $model -> get(input('id')); 
        $this -> assign('info',$info);
        // 获取分类数据
        $category = $model -> getCateTree(); 
        $this -> assign('category',$category);
        return $this -> fetch();
      }
      $result = $model -> edit();
      if($result === false)
      {
        $this -> error($model->getError());
      }
      $id = input('id');
      $this -> success('不错喲,骚年!');
    }

}

?>