<?php
namespace app\admin\validate;
use think\Validate;
class Admin extends Validate
{
	//定义验证规则
	protected $rule = [
	'username' => 'require|max:30|unique:admin',
	'password' => 'require|min:6',

	];
	//定义
	protected $message = [
	'username.require' => '管理员名称不能为空！',
	'username.unique' => '管理员名称不能重复！',
	'username.max' => '管理员名称不能大于30个字节！',
	'password.require' => '新密码不能为空！',
	'password.min' => '新密码不能小于6个字节！',
	
	];
	protected $scene = [
	];
}


