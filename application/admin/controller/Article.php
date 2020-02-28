<?php
namespace app\admin\controller;
use think\Controller;
class Article extends Base
{
	//文章列表展示
    public function lst()
    {
		//$articlelst=\think\Db::name('article')->alias('a')->join('cate b ','a.cateid= b.id','LEFT')->select();
		$articlelst=\think\Db::name('article')->alias('a')->join('cate b ','a.cateid= b.id','LEFT')
		->field('a.*,b.id as bid,b.catename,b.keywords as bkey,b.desc as bdesc,b.type')->order('id asc')
		->paginate(5)
		->each(function($item, $key){
			$item['time'] = date('Y-m-d',$item['time']);
			return $item;
		});
		
		/* $user = \think\Loader::model('Test');
		$user->write($articlelst); */
		$this->assign('articlelst',$articlelst);
		return $this->fetch();
	}
	//文章添加
	public function add()
    {
		//判断post提交的数据是否有值
		if(request()->isPost()){
			$data=[
				'title'=>input('title'),
				'keywords'=>input('keywords'),
				'author'=>input('author'),
				'desc'=>input('desc'),
				'cateid'=>input('cateid'),
				'classifyid'=>input('classifyid'),
				//'cateid'=>(input('cateid')!='') ? input('cateid') : 10 ,
				//'classifyid'=>(input('classifyid')!='') ? input('classifyid') : 0 ,
				'content'=>input('content'),
				/* 'click'=>input('click'), */
				'time'=>time(),
			];
			//文件上传
			if($_FILES['pic']['tmp_name']){
				// 获取表单上传文件 例如上传了001.jpg
				$file = request()->file('pic');
				// 移动到框架应用根目录/public/uploads/ 目录下
				if($file){
					$info = $file->move(ROOT_PATH . 'public' . DS . '/static/uploads');
					if($info){
					// 成功上传后 获取上传信息
					$data['pic']='/static/uploads/'.date('Ymd').'/'.$info->getFilename();
					// 输出 42a79759f284b767dfcb2a0197904287.jpg
					
					}else{
					// 上传失败获取错误信息
					return $this->error($file->getError());
					}
				}
			}
			//表单数据验证
			$validate = \think\Loader::validate('article');
			if($validate->check($data)){		
				$db=\think\Db::name('article')->insert($data);
				if($db!==false){
					return $this->success('添加成功！','lst');
				}else{
					return $this->error('添加文章失败！');
				}
			}else{
				return $this->error($validate->getError());
			}
		return;
		}
		$cateres=\think\Db::name('cate')->select();
		$classifyres=\think\Db::name('classify')->select();
		$this->assign('cateres',$cateres);
		$this->assign('classifyres',$classifyres);
		return $this->fetch();
	}
	//文章修改
	public function edit()
    {
		//判断post提交的数据是否有值
		if(request()->isPost()){
			$data=[
				'id'=>input('id'),
				'title'=>input('title'),
				'keywords'=>input('keywords'),
				'desc'=>input('desc'),
				'cateid'=>input('cateid'),
				'classifyid'=>input('classifyid'),
				'content'=>input('content'),
				/* 'click'=>input('click'), */
			];
			//文件上传
			if($_FILES['pic']['tmp_name']){
				// 获取表单上传文件 例如上传了001.jpg
				$file = request()->file('pic');
				// 移动到框架应用根目录/public/uploads/ 目录下
				if($file){
					$info = $file->move(ROOT_PATH . 'public' . DS . '/static/uploads');
					if($info){
					// 成功上传后 获取上传信息
					$data['pic']='/static/uploads/'.date('Ymd').'/'.$info->getFilename();
					// 输出 42a79759f284b767dfcb2a0197904287.jpg
					
					}else{
					// 上传失败获取错误信息
					return $this->error($file->getError());
					}
				}
			}
			//表单数据验证
			$validate = \think\Loader::validate('article');
			if($validate->scene('edit')->check($data)){		
				$db=\think\Db::name('article')->update($data);
				if($db!==false){
					return $this->success('修改成功！','lst');
				}else{
					return $this->error('修改文章失败！');
				}
			}else{
				return $this->error($validate->getError());
			}
		return;
		}
		$id=input('id');
		$res=\think\Db::name('article')->where('id',$id)->find();
		$res['content']=htmlspecialchars_decode($res['content']);
		$cateres=\think\Db::name('cate')->select();
		$classifyres=\think\Db::name('classify')->select();
		$this->assign('cateres',$cateres);
		$this->assign('classifyres',$classifyres);
		$this->assign('info',$res);
		return $this->fetch('edit');
	}
	//文章删除
	public function del(){
		$id=input('id');
		if(isset($id)){
			if(db('article')->delete($id)){
				return $this->success('删除成功！','lst');
			}else{
				return $this->error('删除失败！','lst');
			}
		}
	}
}
