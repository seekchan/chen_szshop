<?php 
namespace app\admin\model;
use think\Model;
// 分类模型
class Category extends Model
{   
	// 查询分类数据
	public function getCateTree($id=0,$isClear=false)
	{	
        //查询出所有的数据
        $data = $this -> all();       
        // 格式化数据
        $list = get_cate_tree($data,$id,1,$isClear); //dump($data);exit;
        return $list;
	}
    
    // 删除分类
	public function del($cate_id)
	{
		if($cate_id <= 0)
		{
			$this -> error = '参数错误';
			return false;
		}
		// 查找当前分类是否含有子分类
		// 方法一 
		//$data = $this -> where('parent_id','=',$cate_id) -> find();
		// 方法二
		$data = Category::get(['parent_id'=>$cate_id]);
		if($data)
		{
			$this -> error = '子分类不能删除';
			return false; 
		}
		$this -> destroy($cate_id);
		return true;
	}
	// 编辑分类
	public function edit()
	{
		$data = input();
		$tree = $this -> getCateTree($data['id']);  
		//dump($tree);exit;
		foreach ($tree as $key => $value) 
		{
			if($value['id'] == $data['parent_id'])
			{
				$this -> error = '上级分类设置错误';
				return false;
			}
		}
		if($data['parent_id'] == $data['id'])
		{
			$this -> error = '设置错误';
			return false;
		}
		// 修改分类数据
		$this -> update($data);
		return true;
	}
}

?>