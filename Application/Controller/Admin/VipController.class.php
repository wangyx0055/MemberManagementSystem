<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/23
 * Time: 13:08
 */
class VipController extends PlatformController{
    public function lists(){
        $vipmodel=new VipModel();
        $rows=$vipmodel->getAll();
        $this->assign('rows',$rows);
        $this->display('lists');
    }
    public function add(){
        if($_SERVER['REQUEST_METHOD']=$_POST){
            $data=$_POST;
            $vipmodel=new VipModel();
            $result=$vipmodel->add($data);
            if($result===false){
                $this->redirect('index.php?p=Admin&c=Vip&a=add',$vipmodel->getError(),3);
            }else{
                $this->redirect('index.php?p=Admin&c=Vip&a=lists');
            }
        }else{
            $this->display('add');
        }
    }
    public function edit(){
        if($_SERVER['REQUEST_METHOD']=$_POST){
            $data=$_POST;
            $vipmodel=new VipModel();
            $result=$vipmodel->update($data);
            if($result===false){
                $this->redirect('index.php?p=Admin&c=Vip&a=edit',$vipmodel->getError(),3);
            }else{
                $this->redirect('index.php?p=Admin&c=Vip&a=lists');
            }
        }else{
            $id=$_GET['id'];
            $vipmodel=new VipModel();
            $rows=$vipmodel->getOne($id);
            $this->assign($rows);
            $this->display('edit');
        }
    }
}