<?php
namespace app\admin\controller;
use think\Controller;
class Admin extends Base
{
	//管理员列表展示
    public function lst()
    {
		$adminlst=\think\Db::name('admin')->order('id asc')->paginate(5);
		$this->assign('adminlst',$adminlst);
		return $this->fetch();
	}
	//管理员添加
	public function add()
    {
		//判断post提交的数据是否有值
		if(request()->isPost()){
			$data=[
				'username'=>input('username'),
				'password'=>md5(input('password')),
			];
			//表单数据验证
			$validate = \think\Loader::validate('admin');
			if($validate->check($data)){		
				$db=\think\Db::name('admin')->insert($data);
				if($db!==false){
					return $this->success('添加成功！','lst');
				}else{
					return $this->error('添加管理员失败！');
				}
			}else{
				return $this->error($validate->getError());
			}
		return;
		}
		return $this->fetch();
	}
	//管理员修改
	public function edit()
    {
		//判断post提交的数据是否有值
		if(request()->isPost()){
			$res=\think\Db::name('admin')->where('id',input('id'))->find();
			if(md5(input('password'))==$res['password']){
				$data=[
					'id'=>input('id'),
					'username'=>input('username'),
					'password'=>md5(input('npassword')),
				];	
				$validate = \think\Loader::validate('admin');
				//var_dump($validate);
				if($validate->check($data)){		
					$db=\think\Db::name('admin')->update($data);
					if($db!==false){
						return $this->success('修改密码成功！','lst');
					}else{
						return $this->error('修改密码失败！','lst');
					}
				}else{
					return $this->error($validate->getError());
				}
				return;
			}else{
				return $this->error('输入的原密码不正确');
			}		
		}
		$id=input('id');
		$res=\think\Db::name('admin')->where('id',$id)->find();
		$this->assign('info',$res);
		return $this->fetch('edit');
	}
	//管理员删除
	public function del(){
		$id=input('id');
		if(isset($id)){
			if($id==1){
				return $this->error('超级管理员不可删除！');
			}
			if(db('admin')->delete($id)){
				return $this->success('删除管理员成功！','lst');
			}else{
				return $this->error('删除管理员失败！','lst');
			}
		}
	}
}
