<?php 
namespace app\admin\model;
use think\Model;
// 权限模型
class Privilege extends Model
{   
	// 查询权限数据
	public function getPri($id=0,$isClear=false)
	{	
        //查询出所有的数据
        $data = $this -> all();       
        // 格式化数据
        $list = get_cate_tree($data,$id,1,$isClear); //dump($data);exit;
        return $list;
	}

	// 权限编辑
	public function edit()
	{
		$data = input(); 
		$tree = $this -> getPri($data['id']); 
		foreach ($tree as $key => $value) {
			if ($value['id'] == $data['parent_id']) {
				$this -> error = '上级权限设置错误';
				return false;
			}
		}
		if ($data['id'] == $data['parent_id']) {
				$this -> error = '上级权限设置错误';
				return false;
			}
		return $this -> update($data);

	}	
}