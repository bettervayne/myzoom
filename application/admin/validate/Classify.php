<?php
namespace app\admin\validate;
use think\Validate;
class Classify extends Validate
{
	//定义验证规则
	protected $rule = [
	'cname' => 'require|max:30|unique:classify',
	'cateid' => 'require',

	];
	//定义
	protected $message = [
	'cname.require' => '分类名称不能为空！',
	'cname.unique' => '分类名称不能重复！',
	'cname.max' => '分类名称不能大于30个字节！',
	'cateid.require' => '所属栏目不能为空！',
	
	];

}


