<?php
namespace app\admin\validate;
use think\Validate;
class Message extends Validate
{
	//定义验证规则
	protected $rule = [
	'nickname' => 'require',
	'email'=>'email'
	];
	//定义验证后提示信息
	protected $message = [
	'nickname.require' => '栏目名称不能为空！',
	'email.email' => 'email格式不正确！',
	
	];
	protected $scene = [
	'save' => ['nickname'],
	];
}


