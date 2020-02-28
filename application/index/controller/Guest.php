<?php
namespace app\index\controller;
use think\Controller;
class Guest extends Base
{
    public function index()
    {	
		$comment = $this->commentList(0,0);
		$i=1;
		foreach($comment as $k => $v){
			//$comment[$k]['level']=($v['level']-1)*55;
			$comment[$k]['time']=date('Y-m-d H:i:s',$v['time']);
			if($v['level']==1){
				$comment[$k]['lou']=$i;
				$i++;
			}
		}
		//$res=\think\Db::name('guest')->select();
		
		//php array_reverse()函数，数组倒序输出
		$commentd=array_reverse($comment);
		//php json_encode()函数，将数据转换成json格式
		$jsoncomment=json_encode($commentd);
		$this->assign('info',$comment);
		$this->assign('jcomment',$jsoncomment);
		return $this->fetch('tt');
	}
	
	//评论列表
	/* public function commentList($pid=0,&$clist=array())
	{	
		//static $clist=array();
		$res=\think\Db::name('guest')->where('pid',$pid)->select();
		foreach($res as $k => $v){
			$clist=$res;
			$this->commentList($v['id'],$clist);
		}
		$user = \think\Loader::model('Test');
		$user->write($clist);
		
		return $clist;
		

	} */
	
	
	//读取评论列表的递归,code为文章代号，pcode为父级代号
    public function commentList($code,$pid){
        $clist = array(); //存储评论数组
        $list = \think\Db::name('guest')->where('pid',$pid)->select();
        
        foreach($list as $k => $v){
            $clist[] = $v;
            //查询子回复
            $zi = $this->commentList($code,$v["id"]);
            if(count($zi)){
                foreach($zi as $k1 => $v1){
                    $clist[] = $v1;
                }
            }
        }
		/* $user = \think\Loader::model('Test');
		$user->write($clist); */
        return $clist;
    }
	
	
	public function add()
    {		
			//先新增部分字段
			$homepage=substr(input('homepage'),0,7)!='http://' ? ('http://'.input('homepage')) : input('homepage');		
			$data=[
				'nickname'=>input('nickname'),
				'email'=>input('email'),
				'homepage'=>$homepage,
				'content'=>input('content'),
				'time'=>time(),
				'pid'=>input('pid')!=' ' ? input('pid') : 0				
			];
			$db=\think\Db::name('guest')->insert($data);
			//然后更新path，level字段
			$userId = \think\Db::name('guest')->getLastInsID();	
			$pinfo=\think\Db::name('guest')->where('id',input('pid'))->find();		
			if(!isset($pinfo['path'])){
				$path='0,'.$userId;
			}else{
				$path=$pinfo['path'].','.$userId;
			}
			$level=substr_count($path,',');
			$dupdate=\think\Db::name('guest')->where('id',$userId)->update(['path' => $path,'level' => $level]);
			$user = \think\Loader::model('Test');
			$user->write($data);
			
			if($dupdate!=false)
			{
				
				return json(['status'=>1,'msg'=>'添加留言成功']);//如果添加成功输出“OK”，eval代表数据类型为字符串。
			}
			else
			{
				return json(['status'=>0,'msg'=>'添加留言失败']);//如果添加失败，就输出”NO“。
			}
			
	}
	
	
}
