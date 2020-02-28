<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function arr_unique($arr2D){
	//数组拆分
	foreach ($arr2D as $k => $v){
		$v=join('',$v);
		$temp[]=$v;
	}
	$temp=array_unique($temp);
	foreach ($temp as $k => $v){
		$temp[$k]=explode(',',$v);
		
	}
	return $temp;
	
}