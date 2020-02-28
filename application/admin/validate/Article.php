<?php
namespace app\admin\validate;
use think\Validate;
class Article extends Validate
{
	//定义验证规则
	protected $rule = [
	'title' => 'require|max:60|unique:article',
	'keywords' => 'require',
	'cateid' => 'require',
	'classifyid' => 'require',

	];
	//定义
	protected $message = [
	'title.require' => '文章名称不能为空！',
	'title.unique' => '文章名称不能重复！',
	'title.max' => '文章名称不能大于24个字节！',
	'keywords.require' => '关键字不能为空！',
	'cateid.require' => '所属栏目不能为空！',
	'classifyid.require' => '所属分类不能为空！',
	
	];
	protected $scene = [
	'edit' => ['title','keywords','cateid','classifyid'],
	];
}


