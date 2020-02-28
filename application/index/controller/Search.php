<?php
namespace app\index\controller;
use think\Controller;
class Search extends Controller
{
    public function index()
    {
		return $this->fetch('search');
	}
}
