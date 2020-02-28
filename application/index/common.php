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

//二维数组去重，注意角标id会变成0、keywords会变成1
/* array(
	'0'=>array (
	'id' => 1,
	'keywords' => '名言，警句',
	)
);

array (
	0 => array (
	0 => 1,
	1 => '名言，警句',
	),
) */
function arr_unique($arr2D){
	//数组拆分
	foreach ($arr2D as $k => $v){
		$v=join(',',$v);
		$temp[]=$v;
	}
	//数组去重
	$temp=array_unique($temp);
	foreach ($temp as $k => $v){
		$temp[$k]=explode(',',$v);		
	}
	return $temp;
	
}




