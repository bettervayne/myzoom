<?php
namespace app\admin\controller;
use think\Controller;
class Cate extends Base
{
	//栏目列表展示
    public function lst()
    {
		$catelst=\think\Db::name('cate')->order('id asc')->paginate(5);
		$this->assign('catelst',$catelst);
		return $this->fetch();
	}
	//栏目添加
	public function add()
    {
		//判断post提交的数据是否有值
		if(request()->isPost()){
			$data=[
				'catename'=>input('catename'),
				'keywords'=>input('keywords'),
				'desc'=>input('desc'),
				'type'=>input('type') ? input('type'):'0',
			];
			//表单数据验证
			$validate = \think\Loader::validate('Cate');
			if($validate->check($data)){		
				$db=\think\Db::name('cate')->insert($data);
				if($db!==false){
					return $this->success('添加成功！','lst');
				}else{
					return $this->error('添加栏目失败！');
				}
			}else{
				return $this->error($validate->getError());
			}
		return;
		}
		return $this->fetch();
	}
	//栏目修改
	public function save()
    {
		//判断post提交的数据是否有值
		if(request()->isPost()){
			$data=[
				'id'=>input('post.id'),
				'catename'=>input('catename'),
				'keywords'=>input('keywords'),
				'desc'=>input('desc'),
				'type'=>input('type') ? input('type'):'0',
			];		
			$validate = \think\Loader::validate('Cate');
			//var_dump($validate);
			if($validate->scene('save')->check($data)){		
				$db=\think\Db::name('cate')->update($data);
				if($db!==false){
					return $this->success('修改成功！','lst');
				}else{
					return $this->error('修改栏目失败！','lst');
				}
			}else{
				return $this->error($validate->getError());
			}
			return;
		}
		$id=input('id');
		$res=\think\Db::name('cate')->where('id',$id)->find();
		$this->assign('info',$res);
		return $this->fetch('save');
	}
	
	
	//栏目删除
	public function del(){
		$id=input('id');
		if(isset($id)){
			if(db('cate')->delete($id)){
				return $this->success('删除成功！','lst');
			}else{
				return $this->error('删除失败！','lst');
			}
		}
	}
}

