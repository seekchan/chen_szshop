<?php 
namespace app\admin\model;
use think\Model;
use think\Db;
use think\Image;
/*
商品模型
 */
class Goods extends Model
{
	public function addGoods()
	{	
		// 获取所有提交的数据
		$goodsData = input();  //dump($goodsData);exit;
		
		// 商品上架时间
		$goodsData['addtime'] = time();
		// 实现商品图片处理
		if($this -> uploadImg($goodsData) === false)
		{
			return false;
		}
		// 检查货号
		if($this -> checkGoodsSn($goodsData,'add') === false)
		{
			$this -> error = '货号错误';
			return false;
		}
		// 验证数据
		$validate = validate('Goods'); 
		if(!$validate->check($goodsData))
		{
			$this -> error = $validate -> getError(); 
			return false;
		}
		Db::startTrans();  //开启事务
		try{
			$this -> allowField(true) -> save($goodsData);
			// 获取商品id 
			$goods_id = $this -> getLastInsId();
			// 调用自定义方法 属性值入库
			model('GoodsAttr') -> add_attr_value($goods_id,input('attr/a'));
			// 商品相册添加图库
			$this -> uploads_goods_img($goods_id);
			Db::commit();
		}catch(\Exception $e){
			Db::rollback();
			$this -> error = '数据写入错误';
			return false;
		}
	}

	// 检查商品的货号  &表示引用传递  
	public function checkGoodsSn(&$goodsData,$method='add')
	{
		if(!$goodsData['goods_sn'])
		{
			// 商品货号为空时 自动生成字符串
			// uniqid() : php中内置函数,自动生成唯一字符串
			$goodsData['goods_sn'] = uniqid();
			return true;   
		}
		if($method == 'add')
		{
			$hwere = ['goods_sn' => $goodsData['goods_sn']];
		}else{
			// 修改商品
			$where = [
				'goods_sn' => $goodsData['goods_sn'],
				'id' => ['neq',$goodsData['id']],
			];
		}
		// 商品货号重复时
		if($this -> where($where) -> find())
		{
			return false;	
		}
	}

	// 处理商品图片 $isMust作用是否必须上传图片
	// 用于区分商品编辑与添加  
	public function uploadImg(&$goodsData,$isMust=true)
	{
		// 获取文件上传的对象
		$file = request() -> file('goods_img');
		// 判断图片是否上传
		if($file === NULL)
		{
			if($isMust)
			{
				$this -> error = '图片必须上传';
				return false;
			}else{
				// 没有上传图片 但是允许不上传图片
				return true;
			}
		}
		// 实现文件上传
		$info = $file -> validate(['ext' => 'jpg,png,jpeg']) -> move('uploads');
		// 组装出上传的地址 / 代表根目录 属于绝对地址
		// 在浏览器中解析源地址 / 代表是项目根目录即域名
		$goodsData['goods_img'] = str_replace('\\','/','uploads/'.$info -> getSaveName());
		// 生成缩略图
		$img = Image::open($goodsData['goods_img']);
		// 组装缩略图保存地址
		$goodsData['goods_thumb'] = 'uploads/'.date('Ymd').'/thumb_'.$info -> getFileName();
		$img -> thumb(100,100) -> save($goodsData['goods_thumb']);
		// 写入数据库
		$imgdata = [
			['goods_img'=>$goodsData['goods_img']],
			['goods_img'=>$goodsData['goods_thumb']],
		];
		Db::name('cron_img')->insertAll($imgdata);
		// 将资源文件转移到服务器上
		/*upload_img_to_cdn($goodsData['goods_img']);
		upload_img_to_cdn($goodsData['goods_thumb']);*/
	}

	// 上传相册图片
	public function uploads_goods_img($goods_id)
	{
		$list = [];
		$files = request() -> file('pic');
		foreach ($files as $file) {
			$info = $file -> validate(['ext'=>'jpg,png,jpeg']) -> move('uploads');
			if(!$info){
				return false;
			}
			// 相册图片保存地址
			$img = str_replace('\\','/','uploads/'.$info -> getSaveName());
			// 缩略图保存地址
			$thumbOpen = Image::open($img);
			$thumb = 'uploads/'.date('Ymd').'/thumb_'.$info -> getFileName();
			$thumbOpen -> thumb(100,100) -> save($thumb);
			// 将资源文件转移到服务器上
			/*upload_img_to_cdn($img);
			upload_img_to_cdn($thumb);*/
			$list[] = [
				'goods_id' => $goods_id,
				'goods_img'=> $img,
				'goods_thumb'=> $thumb,
			];
			// 写入数据库
			$imgdata = [
				['goods_img'=>$img],
				['goods_img'=>$thumb],
			];
			Db::name('cron_img')->insertAll($imgdata);
		}
		//dump($list);exit;
		if ($list) {
			$result =Db::name('goods_img') -> insertAll($list);
		}
	}

	// 查询商品所有数据
	public function listGoods($is_del=0)
	{
		// 定义未被删除的数据
		$where = ['is_del' => $is_del];
		$cate_id = input('cate_id/d'); // dump(input());exit;
		if($cate_id)
		{
			// 表示有使用分类作为条件搜索 获取当前分类下的所有分类 
			$son = model('category') -> getCateTree($cate_id,true);
			// 组装所需的id数组
			$ids = [$cate_id];   // 将自身也加入条件中 
			foreach ($son as $key => $value) 
			{
				$ids[] = $value['id'];
			}
			// implode 将一个一维数组转换为字符串
			$ids = implode(',',$ids);
			$where['cate_id'] = ['in',$ids];			
		}
		// 推荐搜索
		$intro_type = input('intro_type');
		if($intro_type)
		{
			$where[$intro_type] = 1;
		}
		$is_sale = input('is_sale/d');
		// 上架搜索
		if($is_sale)
		{
			if($is_sale == 1)
			{
				$where['is_sale'] = 1; 
			}elseif($is_sale == 2){
				$where['is_sale'] = 0;
			}
		}
		// 关键字搜索
		$keyword = input('keyword'); 
		if($keyword)
		{
			$where['goods_name'] = ['like',$keyword.'%'];
		}
		$list = $this -> alias('a') -> field('a.*,c.cname')-> where($where) -> join('category c','a.cate_id=c.id','left') -> paginate(5,false,['query'=>input()]);
		//echo $this ->getLastSql();exit;
		//dump($list);exit;
		// 分页显示数据
		return $list; 
	}

	// 商品编辑
	public  function edit()
	{
		$goodsData = input();  //dump($goodsData);exit;
		// 检查货号
		if($this -> checkGoodsSn($goodsData,'edit') === false)
		{
			$this -> error = '货号错误';
			return false;
		}
		// 实现商品图片处理
		if($this -> uploadImg($goodsData,false) === false)
		{
			return false;
		}
		// 验证修改的数据
		$validate = validate('goods');
		if(!$validate -> check($goodsData))
		{
			$this -> error = $validate -> getError(); 
			return false;
		}
		// dump($goodsData);exit;
		$result = $this -> allowField(true) -> isUpdate(true) -> save($goodsData,['id'=>$goodsData['id']]);
		// echo $this ->getLastSql();exit;
		// 商品属性的编辑入库
		$attrModel = model('goods_attr');
		$attrModel -> where('goods_id','=',$goodsData['id']) -> delete();
		// dump($goodsData['attr']);exit;
		$attrModel -> add_attr_value($goodsData['id'],input('attr/a'));
		// 相册编辑
		$this -> uploads_goods_img($goodsData['id']);
		return $result;
	}

	// 切换商品状态
	public function setStatus($goods_id,$field)
	{
		// 定义容许修改的字段
		$allow = ['is_sale','is_hot','is_rec','is_new'];
		if(!in_array($field,$allow))
		{
			$this -> error = '非法参数';
			return false;
		}
		// 获取当前商品字段所对应的状态
		$map = ['id' => $goods_id];
		$goodsInfo = $this -> where($map) -> find();
		// 获取当前商品状态
		$nowStatus = $goodsInfo -> getAttr($field);
		// 计算需要修改的值
		$status = $nowStatus?0:1;
		// setField用于指定字段修改 (字段名,字段值)
		// (['字段1'=>值1,'字段2'=>值2])
		$this -> where($map) -> setField($field,$status);
		return $status;
	}
}

?>