<?php


class IndexController extends PlatformController
{
    public function index(){
        $plansModel = new PlansModel();
        $rows = $plansModel->getAll2();
        //分配套餐数据
        $this->assign('plan',$rows);
        //3.显示页面
        $his= new HisModel();
        $rows3=$his->Amount();
        $this->assign('row3',$rows3);
        $rows2=$his->Amount2();
        $this->assign('row2',$rows2);
        $rows1=$his->Amount1();
        $this->assign('row1',$rows1);
        $this->display('index');
    }
    public function about(){
            $this->display('about');
    }

}