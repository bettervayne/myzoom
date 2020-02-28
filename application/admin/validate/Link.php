<?php
namespace app\admin\validate;
use think\Validate;
class Link extends Validate
{
	//定义验证规则
	protected $rule = [
	//****注意修改unique后边的表名****
	'title' => 'require|max:30|unique:link',
	'url' => 'url',

	];
	//定义
	protected $message = [
	'title.require' => '链接名称不能为空！',
	'title.unique' => '链接名称不能重复！',
	'title.max' => '链接名称不能大于30个字节！',
	'url.require' => '地址填写不规范！',
	
	];
	protected $scene = [
	'edit' => ['title','url'],
	];
}


