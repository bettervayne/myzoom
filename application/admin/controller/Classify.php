<?php
namespace app\admin\controller;
use think\Controller;
class Classify extends Base
{
	//文章分类列表展示
    public function lst()
    {
		$classifylst=\think\Db::name('classify')->alias('a')->field('a.id,a.cname,a.desc,b.catename')
		->join('ym_cate b','a.cateid=b.id','left')->order('a.id desc')->paginate(5);
		$this->assign('classifylst',$classifylst);
		return $this->fetch();
	}
	//文章分类添加
	public function add()
    {
		//判断post提交的数据是否有值
		if(request()->isPost()){
			$data=[
				'cname'=>input('cname'),
				'desc'=>input('desc'),
				'cateid'=>input('cateid')
			];
			//表单数据验证
			$validate = \think\Loader::validate('Classify');
			if($validate->check($data)){		
				$db=\think\Db::name('classify')->insert($data);
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
		$cate_info=\think\Db::name('cate')->order('id asc')->select();
		$this->assign('cate_info',$cate_info);
		return $this->fetch();
	}
	//文章分类修改
	public function save()
    {
		//判断post提交的数据是否有值
		if(request()->isPost()){
			$data=[
				'id'=>input('id'),
				'cname'=>input('cname'),
				'desc'=>input('desc'),
				'cateid'=>input('cateid')
			];	
			$validate = \think\Loader::validate('Classify');
			//var_dump($validate);
			if($validate->check($data)){		
				$db=\think\Db::name('Classify')->update($data);
				if($db!==false){
					return $this->success('修改成功！','lst');
				}else{
					return $this->error('修改分类失败！','lst');
				}
			}else{
				return $this->error($validate->getError());
			}
			return;
		}
		$id=input('id');

		$cate_info=\think\Db::name('cate')->order('id asc')->select();
		$classify_info=\think\Db::name('classify')->where('id',$id)->find();
		$this->assign('cate',$cate_info);
		$this->assign('info',$classify_info);
		return $this->fetch('save');
	}
	
	
	//文章分类删除
	public function del(){
		$id=input('id');
		if(isset($id)){
			if(db('classify')->delete($id)){
				return $this->success('删除成功！','lst');
			}else{
				return $this->error('删除失败！','lst');
			}
		}
	}
}

