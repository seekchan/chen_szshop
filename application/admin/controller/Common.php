<?php 
namespace app\admin\controller;
use think\Controller;
use think\Request;
//公共控制器
class Common extends Controller
{
	public $request;     //保存Request类对象
	public $is_check_rule = true; //标识符
	public $user = [];
	public function __construct(Request $request)
	{
		//执行父类的构造方法
		parent::__construct();
		$this -> request = request();
		// 检查是否已经登录 防止翻墙
		if(!cookie('admin_id')){
			$this -> error('想翻墙?先给钱!','login/index');
		}
		// 读取缓存中的内容
		//cache('user_power_'.cookie('admin_id'),null);
		$this->user = cache('user_power_'.cookie('admin_id'));
		if (!$this->user) {
			// 校验用户的访问权限
			// 将用户的标识保存到属性中
			$this->user['admin_id'] = cookie('admin_id'); 
			// 根据用户的id获取到角色ID
			$role_info = db('admin_role')->where(['admin_id'=>$this->user['admin_id']])->find(); 
			if (!$role_info) {
				$this -> error('角色信息错误','login/index'); 
			}
			// 将角色信息保存到属性中
			$this->user['role_id'] = $role_info['role_id'];
			$privileges = [];
			// 判断角色
			if ($this->user['role_id'] == 1) {
				// 超级管理员   设置不校验权限
				$this->is_check_rule = false;
				// 查询所有的权限信息(由于要显示导航菜单)
				$privileges = db('privilege')->select();
			}else{
				$data = db('role_privilege')->where(['role_id'=>$this->user['role_id']])->select();
				foreach ($data as $key => $value) {
					$privilege_ids[] = $value['privilege_id']; 
				}
				$privileges = db('privilege')->where('id','in',$privilege_ids)->select();
			}
			foreach ($privileges as $key => $value) {
				// 将当期用户具备的权限保存到属性中
				$this->user['privilege'][] = $value['controller_name'].'/'.$value['action_name'];
					// 将权限中需要显示的菜单保存到属性中
				if ($value['is_show'] == 1) {
					$this->user['menus'][] = $value;
			    }
		    }
		    // 将数据写入到缓存
			cache('user_power_'.cookie('admin_id'),$this->user);
		}
		// 超级管理员角色不进行任何的权限认证
		if ($this->user['role_id'] == 1) {
			return;
		}
		// 由于超级管理员角色下的用户无需要检查权限
		if ($this->is_check_rule) {
			// 后台首页的访问权限任何用户都可以访问
			$this->user['privilege'][] = 'index/index';
			$this->user['privilege'][] = 'index/top';
			$this->user['privilege'][] = 'index/menu';
			$this->user['privilege'][] = 'index/main'; 
			$action = strtolower(request()->controller().'/'.request()->action());
			if (!in_array($action,$this->user['privilege'])) {
				$this -> error('无权访问','login/index');
			}
		}
	}   

	
}

?>