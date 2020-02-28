<?php
namespace app\admin\controller;
use think\Controller;
class Link extends Base
{
	//链接列表展示
    public function lst()
    {
		//$linklst=\think\Db::name('link')->select();
		$linklst=\think\Db::name('link')->order('id asc')->paginate(5);
		$this->assign('linklst',$linklst);
		return $this->fetch();
	}
	//链接添加
	public function add()
    {
		//判断post提交的数据是否有值	
		if(request()->isPost()){
			$data=[
				'title'=>input('title'),
				'descr'=>input('descr'),
				'url'=>input('url'),
				
			];
			//表单数据验证
			$validate = \think\Loader::validate('Link');
			if($validate->check($data)){		
				$db=\think\Db::name('link')->insert($data);
				if($db!==false){
					return $this->success('添加成功！','lst');
				}else{
					return $this->error('添加链接失败！');
				}
			}else{
				return $this->error($validate->getError());
			}
		return;
		}
		return $this->fetch();
	}
	//链接修改
	public function edit()
    {
		//判断post提交的数据是否有值
		if(request()->isPost()){
			$data=[
				'id'=>input('id'),
				'title'=>input('title'),
				'descr'=>input('descr'),
				'url'=>input('url'),
			];		
			$validate = \think\Loader::validate('Link');
			//var_dump($validate);
			if($validate->scene('edit')->check($data)){		
				$db=\think\Db::name('link')->update($data);
				if($db!==false){
					return $this->success('修改成功！','lst');
				}else{
					return $this->error('修改链接失败！','lst');
				}
			}else{
				return $this->error($validate->getError());
			}
			return;
		}
		$id=input('id');
		$res=\think\Db::name('link')->where('id',$id)->find();
		$this->assign('info',$res);
		return $this->fetch('edit');
	}
	//链接删除
	public function del(){
		$id=input('id');
		if(isset($id)){
			if(db('link')->delete($id)){
				return $this->success('删除成功！','lst');
			}else{
				return $this->error('删除失败！','lst');
			}
		}
	}
}
