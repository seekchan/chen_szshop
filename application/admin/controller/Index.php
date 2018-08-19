<?php
namespace app\admin\controller;
use think\Controller;
class Index extends Common
{
    public function index()
    {   
    	$top = url('top');
    	$main = url('main');
    	$menu = url('menu');
    	$this -> assign('top',$top);
    	$this -> assign('main',$main);
    	$this -> assign('menu',$menu);
        return view();
    }
    public function main()
    {
        //dump($this->user);
    	return view();
    }
    public function menu()
    {
        $this -> assign('menus',$this->user['menus']);
    	return view();
    }
    public function top()
    {
    	return view();
    }


}
