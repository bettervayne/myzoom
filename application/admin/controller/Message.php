<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Message as mes;
class Message extends Base
{
	//留言列表展示
    public function lst()
    {
		$messagelst=\think\Db::name('guest')->order('id asc')->paginate(5);
		$this->assign('messagelst',$messagelst);
		return $this->fetch();
	}
	//留言添加
	public function add()
    {
		if(request()->isPost()){
			$homepage=substr(input('homepage'),0,7)!='http://' ? ('http://'.input('homepage')) : input('homepage');
			$data=[
				'nickname'=>input('nickname'),
				'email'=>input('email'),
				'homepage'=>$homepage,
				'content'=>input('content'),
				'level'=>1,
				'time'=>time(),
			];
			//表单数据验证
			$validate = \think\Loader::validate('Message');
			if($validate->check($data)){
				//实例化mes模型，调用add方法
				$mes=new mes;
				$db=$mes->add($data);
				if($db!==false){
					return $this->success('添加成功！','lst');
				}else{
					return $this->error('添加留言失败！');
				}
			}else{
				return $this->error($validate->getError());
			}
		return;
		}
		return $this->fetch();
	}
	//留言修改
	public function save()
    {
		if(request()->isPost()){
			$homepage=substr(input('homepage'),0,7)!='http://' ? ('http://'.input('homepage')) : input('homepage');
			$data=[
				'nickname'=>input('nickname'),
				'email'=>input('email'),
				'homepage'=>$homepage,
				'content'=>input('content'),
				'level'=>1,
				'time'=>time(),
			];
			//表单数据验证
			$validate = \think\Loader::validate('Message');
			if($validate->scene('save')->check($data)){
				//实例化mes模型，调用add方法
				$mes=new mes;
				$db=$mes->add($data);
				if($db!==false){
					return $this->success('保存成功！','lst');
				}else{
					return $this->error('保存留言失败！');
				}
			}else{
				return $this->error($validate->getError());
			}
		return;
		}
		$id=input('id');
		$res=\think\Db::name('guest')->where('id',$id)->find();
		$this->assign('info',$res);
		return $this->fetch();
	}
	
	//留言删除
	public function del(){
		$id=input('id');
		if(isset($id)){
			if(db('guest')->delete($id)){
				return $this->success('删除成功！','lst');
			}else{
				return $this->error('删除失败！','lst');
			}
		}
	}
}

