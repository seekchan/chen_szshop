<?php
namespace app\index\controller;
use think\Model;
use think\Db;
/*
*商品控制器
*/
class Goods extends Common
{	
	// 商品详情界面显示
	public function detail()
	{
		$goods_id = input('id');
		$goodsInfo = Db::name('goods') -> find($goods_id); 
		if (!$goodsInfo) {
			$this -> error('非法请求');
		}
		if ($goodsInfo['is_sale']==0 || $goodsInfo['is_del']==1) {
			$this -> error('商品已下架');
		}
		$this -> assign('goodsInfo',$goodsInfo);//dump($goodsInfo);exit;
		// 图片相册
		$imgs = Db::name('goods_img') -> where('goods_id','=',$goods_id) -> select();
		$this -> assign('imgs',$imgs);
		// 查询唯一属性和单选属性
		$data = Db::query("select a.attr_name,a.attr_type,b.* from shop_attribute a left join shop_goods_attr b on a.id=b.attr_id where b.goods_id=$goods_id");
		$unique = []; // dump($data);  
		$radio = [];
		foreach ($data as $key => $value) {
			if($value['attr_type'] == 1){
				$unique[] = $value; 
			}else{
				$radio[$value['attr_id']][] = $value; 
			}
		}
		// 面包屑导航
		$navigation = model('goods')->navigation($goodsInfo['cate_id']);
		//dump($navigation);
		$navigation = array_reverse($navigation);
		$this -> assign('navigation',$navigation);
		$this -> assign('unique',$unique);
		$this -> assign('radio',$radio); // dump($radio);exit;
		foreach ($radio as $key => $value) {
			$ids[] = $value[0]['id'];
		} 
		// 库存
		$sku = model('goods') -> setSku($goods_id,$ids);
		$this -> assign('sku',$sku); //dump($sku);exit;
		$hisData = model('goods') -> history($goods_id);
		$this -> assign('hisData',$hisData);
		return $this -> fetch();
	}

	// 设置库存
	public function setSku()
	{
		$data = input('ids/a');
		$goods_id = input('goods_id');
		$ids = [];
		foreach ($data as $value) {
			if ($value) {
				$ids[] = $value;
			}
		} 
		$sku = model('goods') -> setSku($goods_id,$ids);
		//dump($sku);exit;
		return json(['statusCode' => 1,'msg' => 'ok','status' => $sku]);
		
	}

}