<?php 
namespace app\index\model;
use think\Model;
use think\Db;
/**
* 回复商品评论
*/
class Reply extends Model
{
	public function reply()
	{
		// 先判断是否登录
		$userInfo = get_user_info();
		if (!$userInfo) {
			$this->error = '请登录';
			return false;
		}
		// 验证数据
		$data = input();
		$validate = validate('reply');
		if (!$validate->check($data)) {
			$this->error = $validate -> getError();
			return false;
		}
		$time = (date("Y-m-d H:i:s",time()));
		$data['addtime'] = time();
		$data['user_id'] = $userInfo['id']; 
		// 评论数据入库
		$this->allowField(true)->save($data);
		$id = $this->getLastInsID();
		// 返回数据给前台
		$result = [
			'id' => $id,
			'username' => $userInfo['username'],
			'addtime' => $time,
			'content' => $data['content'],
		];
		return $result;
	}
	
}