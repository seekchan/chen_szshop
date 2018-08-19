<?php 
namespace app\index\model;
use think\Model;
use think\Db;
/**
* 评论
*/
class Comment extends Model
{
	// 评论
	public function comment()
	{	
		// 先判断是否登录
		$userInfo = get_user_info();
		if (!$userInfo) {
			$this->error = '请登录';
			return false;
		}
		// 验证数据
		$data = input();
		$validate = validate('comment');
		if (!$validate->check($data)) {
			$this->error = $validate -> getError();
			return false;
		}
		$time = (date("Y-m-d H:i:s",time()));
		$data['addtime'] = time(); 
		$data['user_id'] = $userInfo['id'];
		// 买家印象
		$like_id = isset($data['like_id'])?$data['like_id']:[];
		$like_name = $data['like_name'];
		// 处理旧印象  选择旧则增加印象总数
		if ($like_id) {
			foreach ($like_id as $key => $v) {
				db('like')->where('id',$v)->setInc('like_num');
			}
		}
		// 处理新印象
		if($like_name){
			// str_replace 将 3 中全部的 1 都被 2 替换之后的结果
			str_replace('，',',',$data['like_name']);
			$like_name = explode(',',$like_name);
			foreach ($like_name as $key => $value) {
				// trim 去除字符串首尾处的空白字符（或者其他字符）
				$value = trim($value);
				// 先判断数据库是否存在
				$has = db('like')->where(['goods_id'=>$data['goods_id'],'like_name'=>$value])->find();
				// 存在更新  不存在则添加入库
				if ($has) {
					db('like')->where(['goods_id'=>$data['goods_id'],'like_name'=>$value])->setInc('like_num');
				}else{
					db('like')->insert(['goods_id'=>$data['goods_id'],'like_name'=>$value,'like_num'=>1]);
				}
			}
		}
		// 评论数据入库
		$this->allowField(true)->save($data);
		$id = $this->getLastInsID();
		// 返回数据给前台
		$result = [
			'id' => $id,
			'username' => $userInfo['username'],
			'addtime' => $time,
			'content' => $data['content'],
			'star' => $data['star'],
		];
		return $result;
	}
	
	// 分页功能
	public function search($goods_id,$page)
	{
		$pageSize = 5;
		// 取出总的记录数
		$count = $this->alias('a')->where('goods_id',$goods_id)->count();
		// 计算总的页数
		$pageCount = ceil($count/$pageSize);
		// 计算limit上的第一个参数:偏移量
		$offset = ($page-1)*$pageSize;
		// 第一页的好评
		if ($page) {
			// 好评率  取出所有的分值
			$stars = $this->field('star')->where('goods_id',$goods_id)->select();
			// 循环所有分值进行统计  nice:好  fit:中  bad:差
			$nice = $fit = $bad = 0;
			foreach ($stars as $key => $value) {
				if ($value['star'] == 3) {
					$fit++;
				}elseif ($value['star']>3) {
					$nice++;
				}else{
					$bad++;
				}
			}
			$total = $nice + $fit + $bad;  // 总的评论数
			$nice = round(($nice/$total)*100,2);
			$fit = round(($fit/$total)*100,2);
			$bad = round(($bad/$total)*100,2);
			// 取印象
			$likeData = Db::name('like')->where(['goods_id'=>$goods_id])->select(); 
		}
		// 取评论数据和用户名称
		$data = Db::query("SELECT d.username,c.* FROM shop_user d LEFT JOIN (SELECT a.*,COUNT(b.id) reply_count FROM shop_comment a LEFT JOIN shop_reply b ON a.id=b.comment_id WHERE goods_id='$goods_id' GROUP BY a.id ORDER BY a.id DESC LIMIT $offset,$pageSize) c ON c.user_id=d.id WHERE goods_id='$goods_id'");
		foreach ($data as $key => $value) {
			// 评论时间戳转换
			$data[$key]['addtime'] = (date("Y-m-d H:i:s",$value['addtime']));
			// 回复评论数据
			$id = $value['id'];
			$reply = Db::query("SELECT a.*,b.username FROM shop_reply a LEFT JOIN shop_user b ON a.user_id=b.id where a.comment_id = '$id' ORDER BY a.id ASC");
			// 评论时间戳转换
			foreach ($reply as $k => $v) {
				$reply[$k]['addtime'] = (date("Y-m-d H:i:s",$v['addtime']));
			}
			 $data[$key]['reply'] = $reply;
		}
		// 取出当前用户ID
		$userInfo = get_user_info();
		return array(
			'user_id' => $userInfo['id'],
			'data'=>$data,
			'pageCount'=>$pageCount,
			'nice'=>$nice,
			'fit'=>$fit,
			'bad'=>$bad,
			'likeData'=>$likeData,
			);
	}
}