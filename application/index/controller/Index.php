<?php
namespace app\index\controller;
use think\Controller;
class Index extends Base
{
    public function index()
    {
		$artres=\think\Db::name('article')->alias('a')->join('cate b ','a.cateid= b.id','LEFT')
		->field('a.*,b.id as bid,b.catename,b.keywords as bkey,b.desc as bdesc,b.type')->order('id asc')
		->paginate(5)
		->each(function($item, $key){
			$item['time'] = date('Y年m月d日',$item['time']);
			$item['author'] = ($item['author']=='') ? '无' : $item['author'];
			$item['tags'] = str_replace("+","%20",$this->explode_keys($item['keywords']));//urlencode会将空格转成+号，需要替换回来
			return $item;
		});
		/* $user = \think\Loader::model('Test');
		$user->write($artres); */
		$link=\think\Db::name('link')->order('id desc')->select();
		$this->assign('link',$link);
		$this->assign('artres',$artres);
		return $this->fetch();
	}
	
	//分解关键字作为标签
	public function explode_keys($keywords){
		$str="";
		$arr=explode(',',$keywords);
		foreach($arr as $key=>$value){	
			$str.="<a href='".url('index/Tags/index',['tags'=>$value])."' >$value</a>&nbsp;&nbsp;";
		}
		return $str;
	}
}
