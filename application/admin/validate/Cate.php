<?php
namespace app\admin\validate;
use think\Validate;
class Cate extends Validate
{
	//定义验证规则
	protected $rule = [
	'catename' => 'require|max:30|unique:cate',
	'keywords' => 'require',

	];
	//定义
	protected $message = [
	'catename.require' => '栏目名称不能为空！',
	'catename.unique' => '栏目名称不能重复！',
	'catename.max' => '栏目名称不能大于30个字节！',
	'keywords.require' => '关键字不能为空！',
	
	];
	protected $scene = [
	'save' => ['catename'],
	];
}


