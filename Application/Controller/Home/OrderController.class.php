<?php
class OrderController extends PlatformController{
    public function about(){
       $ordermodel=new OrderModel();
        $page = isset($_GET['page']) ? $_GET['page']:1;
        $pageSize = 3;
        $pageResult = $ordermodel->User_getPage($page,$pageSize);

        $ordermodel=new OrderModel();
        $data=$ordermodel->Allget();
        $this->assign('rs', $data);
        $this->assign($pageResult);
        $this->display('about');
    }
    public function dingdan(){

    }

    public function remove(){
        $order_id=$_GET['id'];
        $ordermodel=new OrderModel();
        $ordermodel->remove($order_id);
        $this->redirect('index.php?p=Home&c=Order&a=about');
    }

    public function add(){
        if($_SERVER['REQUEST_METHOD']=$_POST){
            $data=$_POST;
            $ordermodel=new OrderModel();
            $result=$ordermodel->add($data);
            if($result===false){
                $this->redirect('index.php?p=Home&c=Order&a=add',$ordermodel->getError(),3);
            }else{
                $this->redirect('index.php?p=Home&c=Order&a=about');
            }
        }else{
            $members=new MembersModel();
            $rows=$members->getAll();
            $this->assign('rows',$rows);
            $this->display('add');
        }
    }
}