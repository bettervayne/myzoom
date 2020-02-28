<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Login as log;
class Login extends Controller
{
	//登录
    public function login()
    {
		/* $linklst=\think\Db::name('link')->paginate(4);
		$this->assign('linklst',$linklst); */
		if(request()->ispost()){		
			$log= new log;
			$status=$log->login(input('username'),input('password'));
			if($status==1){
				return $this->success('登录成功','Index/index');
			}elseif($status==2){
				return $this->error('用户名或密码错误！');
			}else{
				return $this->success('管理员不存在！');
			}
			
		}
		return $this->fetch();
	}
	//退出登录
	public function logout()
	{
		session(null);
		return $this->redirect('Login/login',3,'退出登录，跳转到登录页');
	}
	
}
