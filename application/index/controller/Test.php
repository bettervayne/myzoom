<?php
namespace app\index\controller;
use think\Controller;
class Test extends Base{
	public function index(){
		
		return $this->fetch('');
		
	}
	
	public function addchuli()
    {
		
		
		//var_dump($_POST);
        $db=\think\Db::name('test')->insert($_POST);//调用添加的方法
        if($db!=false)
        {
			return json(['status'=>1,'msg'=>'添加留言成功']);//如果添加成功输出“OK”，eval代表数据类型为字符串。
        }
        else
        {
            return json(['status'=>0,'msg'=>'添加留言失败']);//如果添加失败，就输出”NO“。
        }
    }
	
	public function tes(){
		
		return $this->fetch('');
		
	}
}

?>