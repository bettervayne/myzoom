<?php
namespace app\index\controller;
use think\Controller;
class Tags extends Base
{
    public function index()
    {
		/* $artres=\think\Db::name('article')->alias('a')->join('cate b ','a.cateid= b.id','LEFT')
		->field('a.*,b.id as bid,b.catename,b.keywords as bkey,b.desc as bdesc,b.type')->order('id asc')
		->where('a.cateid',input('cateid'))->paginate(2)
		->each(function($item, $key){
			$item['time'] = date('Y年m月d日',$item['time']);
			return $item;
		});
		$this->assign('artres',$artres); */
		$tags=input('tags');
		$map['a.keywords']=['like','%'.$tags.'%'];
		//分页函数(paginate())中需要添加搜索关键字，才能在点击下一页时显示搜索的内容；不加会显示所有内容。
		//request()->param('tags')该方法可以得到当前连接中tags参数的值。
		$artres=\think\Db::name('article')->alias('a')->join('cate b ','a.cateid= b.id','LEFT')
		->field('a.*,b.id as bid,b.catename,b.keywords as bkey,b.desc as bdesc,b.type')->order('id asc')
		->where($map)->paginate(2,false,['query'=>request()->param()])
		->each(function($item, $key){
			$item['time'] = date('Y年m月d日',$item['time']);
			$item['tags'] = str_replace("+","%20",$this->explode_keys($item['keywords']));//urlencode会将空格转成+号，需要替换回来
			return $item;
		});
		
		$arr="戚薇,刘诗诗";
		$it = $this->explode_keys($arr);
		/* $user = \think\Loader::model('Test');
		$user->write($it); */
		$this->assign('artres',$artres);
		return $this->fetch('lst');
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
