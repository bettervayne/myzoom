<?php
namespace app\admin\model;
use think\Model;
class Login extends Model
{
	public function login($username,$password){
		$info=\think\Db::name('admin')->where('username',$username)->find();
		if($info){
			if(md5($password)==$info['password']){
				\think\Session::set('id',$info['id']);
    			\think\Session::set('username',$info['username']);
				return 1;
			}else{
				return 2;
			}
		}else{
			return 3;
		}
		
	}
}

