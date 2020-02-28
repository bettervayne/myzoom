<?php
namespace app\admin\controller;
use think\Controller;

class Base extends Controller
{
    //初始化方法，预先执行该方法，与构造方法结果类似
	public function _initialize()
    {
		if(!session('id')){
			$this->error('请先登录系统',url('Login/login'));
			//$this->rederict(url('Login/login'));
		}
	}
}
