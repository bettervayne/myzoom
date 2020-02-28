<?php
namespace app\admin\model;
use think\Model;
class Test extends Model
{
	public function write($txt)
     {
        /* $myfile = fopen("file.txt", "w") or die("Unable to open file!");
		fwrite($myfile, $txt);
		fclose($myfile); */
		$myfile = fopen("file.txt", "w") or die("Unable to open file!");
		fwrite($myfile, var_export($txt, true));
		fclose($myfile);

    }
}

/* $user = \think\Loader::model('Test');
		$user->write($articlelst); */
