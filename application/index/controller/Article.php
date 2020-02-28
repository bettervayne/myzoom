<?php
namespace app\index\controller;
use think\Controller;
class Article extends Base
{
    public function index()
    {
		//$artres= \think\Db::name('article')->where('artid',input('artid'))->find();
		$id=input('artid');
		\think\Db::name('article')->where('id',$id)->setInc('click', 1);
		$artres=\think\Db::name('article')->alias('a')->join('cate b ','a.cateid= b.id','LEFT')
		->field('a.*,b.id as bid,b.catename,b.keywords as bkey,b.desc as bdesc,b.type')
		->where('a.id',$id)->find();
		$artres['time'] = date('Y年m月d日',$artres['time']);
		$artres['author'] = ($artres['author']=='') ? '无' : $artres['author'];
		$artres['content']=htmlspecialchars_decode($artres['content']);
		$artres['tags'] = str_replace("+","%20",$this->explode_keys($artres['keywords']));//urlencode会将空格转成+号，需要替换回来		
		$mapp['id'] = ['<',$id];
		$mapp['cateid'] = ['=',$artres['cateid']];
		$mapn['id'] = ['>',$id];
		$mapn['cateid'] = ['=',$artres['cateid']];
		$prev=\think\Db::name('article')->where($mapp)->order('id desc')->limit(1)->value('id');
		$next=\think\Db::name('article')->where($mapn)->order('id asc')->limit(1)->value('id');
		/* $prev=($prev==null) ? $id : $prev;
		$next=($next==null) ? $id : $next; */
		
		$ralates=$this->ralate($artres['keywords']);	
		/* $user = \think\Loader::model('Test');
		$user->write($ralates); */
		$this->assign('prev',$prev);
		$this->assign('next',$next);
		$this->assign('info',$artres);
		$this->assign('ralates',$ralates);
		return $this->fetch('article');
	}
	
	//keywords查询相关文章
	public function ralate($keywords){
		$arr=explode(',',$keywords);			
		static $ralates=array();
		foreach($arr as $key=>$value){
			$map['keywords']  = ['like','%'.$value.'%'];
			$artres=\think\Db::name('article')->field('id,title,time')->where($map)->order('id desc')->limit(5)->select();
			//数组合并
			$ralates=array_merge($ralates,$artres);		
			//数组去重,调用commen.php中函数
			$ralates=arr_unique($ralates);
		}
		return $ralates;
	}
	
	//分解关键字作为标签
	public function explode_keys($keywords){
		$str="";
		$arr=explode(',',$keywords);
		foreach($arr as $key=>$value){	
			$str.="<a href='".url('index/Tags/index',['tags'=>$value])."' >$value</a>&nbsp;&nbsp;";
			//$str.=url('index/Tags/index',['tags'=>$value]);
		}
		/* $user = \think\Loader::model('Test');
		$user->write($str); */
		return $str;
	}
	
	
}


