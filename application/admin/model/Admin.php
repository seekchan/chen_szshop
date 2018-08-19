<?php 
namespace app\admin\model;
use think\Model;
use think\captcha\Captcha;
use think\Db;
//管理员模型类
class Admin extends Model
{
	public function Login()
	{
		$obj = new Captcha();
		if(!$obj -> check(input('captcha')))
		{
			$this -> error = '验证码错误';
			return false;
		}
		$where = 
		[
			'username' => input('username'),
			'password' => md5(strtoupper(input('password'))),
		];
		$userInfo = $this -> where($where) -> find();
		//echo $this -> getLastSql();exit;
		if($userInfo === NULL)
		{
			$this -> error = '用户名或者密码错误';
			return false;
		}
		//获取用户ID属性
		$admin_id = $userInfo -> getAttr('id');
		// 保存用户状态
		cookie('admin_id',$admin_id);
		return true;
	}

	// 添加用户
	public function addUser()
	{
		$data = input(); 
		$rule = [
		  'username' => 'require',
		  'password' => 'require',
		];
		$validate = new \think\Validate($rule);
		if(!$validate -> check($data)){
			$this -> error = $validate -> getError();
			return false;
		}
		$data['password'] = md5($data['password']);
		$this -> startTrans();
		try {
			$this -> allowField(true) -> save($data);
			$admin_id = $this -> getLastInsId(); 
			Db::name('admin_role') -> insert(['admin_id'=>$admin_id,'role_id'=>$data['role_id']]);
			$this -> commit();
		} catch (Exception $e) {
			$this -> rollback();
		}
	}

	// 用户角色界面显示
	public function listAdmin()
	{
		$roleData = [];
		$role = Db::name('role') -> select(); 
		foreach ($role as $key => $value) {
			$roleData[$value['id']] = $value;
		} //dump($roleData);
		
		$admin = $this -> all();
		foreach ($admin as $key => $value) {
			$value = $value -> toArray();
			$adminData[$value['id']] = $value; 
		} //dump($adminData);
		$admin_role = Db::name('admin_role') -> select();
		foreach ($admin_role as $key => $value) {
			$value['role_id'] = $roleData[$value['role_id']];
			$value['admin_id'] = $adminData[$value['admin_id']];
			$data[] = $value; 
		} //dump($data);exit;
		return $data;
	}

	// 查询编辑数据
	public function listEdit()
	{
		$admin_id = input('id'); 
		$info = $this -> alias('a') -> field('a.*,b.role_id,c.role_name') -> join('admin_role b','a.id=b.admin_id','left') -> join('role c','b.role_id=c.id','left') -> find($admin_id); 
		return $info;
	}

	// 编辑用户角色
	public function edit()
	{
		$data = input(); 
		if ($data['password']) {
			$data['password'] = md5($data['password']);
		}else{
			unset($data['password']);
		}
		$role_id = $data['role_id'];
		unset($data['role_id']);
		$this -> where('id','=',$data['id']) -> update($data);
		Db::name('admin_role') -> where('admin_id','=',$data['id']) -> update(['role_id'=>$role_id]);
	}
}

?>