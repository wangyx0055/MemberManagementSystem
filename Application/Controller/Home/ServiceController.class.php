<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/24
 * Time: 11:57
 */
class ServiceController extends PlatformController
{
    public function services(){
        $markChangeShopModel=new MarkChangeShopModel();
        $rows=$markChangeShopModel->getAll();
        $this->assign('rows',$rows);
        $this->display('services');
    }
    public function add(){
        if($_SERVER['REQUEST_METHOD']==='POST'){
            //1.接收数据
            $data = $_POST;
            $str = "ABCDEFGHJKLMNPQRSTUVWXYZ23456789";
            $str = str_shuffle($str);
            $random =substr($str,0,9);
            //2.处理数据
            $serviceModel = new ServiceModel();
            $result=$serviceModel->add($data,$random);

            if ($result==true){
                //3.显示页面
                $this->redirect("index.php?p=Home&c=Order&a=about");
            }else{
                $this->redirect("index.php?p=Home&c=Service&a=services",$serviceModel->getError(),3);
            }

        }else{
            $product_name=$_GET['product_name'];
            $mark=$_GET['mark'];
            $this->assign('mark',$mark);
            $this->assign('product_name',$product_name);
            $this->display('add');
        }
    }
}