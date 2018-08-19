<?php 
namespace app\index\controller;
use think\Controller;
use think\Db;
class Common extends Controller
{
	public function __construct()
	{
		parent::__construct();
		$category = $this -> getCateTree();
		$this -> assign('category',$category);//dump($category);
		$userInfo = get_user_info();
		$this -> assign('userInfo',$userInfo);//dump($userInfo);exit;
	}

	// 查询分类数据
	public function getCateTree()
	{	
		//cache('category',null);
		$category = cache('category');
		if (!$category) {
			//查询出所有的数据
	        $data = Db::name('category') -> select();       
	        // 格式化数据
	        $category = get_cate_tree($data); //dump($data);exit;
	        cache('category',$category);
		} 
        return $category;
	}

	// 下单时检测是否登录
	public function checkLogin()
	{
		$userInfo = get_user_info();
		if (!$userInfo) {
			$this -> error('请先登录!','user/login');
		}
	}
}

?>