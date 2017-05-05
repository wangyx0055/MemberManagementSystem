<?php
class OrderController extends PlatformController{
    public function lists(){
        $ordermodel=new OrderModel();
        $page = isset($_GET['page']) ? $_GET['page']:1;
        $pageSize = 2;
        $pageResult = $ordermodel->getPage($page,$pageSize);
        $this->assign($pageResult);
        $this->display('lists');
    }
    public function no_order(){
        $order_id=$_GET['id'];
        $ordermodel=new OrderModel();
        $ordermodel->no_order($order_id);
        $this->redirect('index.php?p=Admin&c=Order&a=lists');
    }
    public function can_order(){
        $order_id=$_GET['id'];
        $ordermodel=new OrderModel();
        $ordermodel->can_order($order_id);
        $this->redirect('index.php?p=Admin&c=Order&a=lists');
    }
    public function reply(){
        if($_SERVER['REQUEST_METHOD']=$_POST){
            $data=$_POST;
            $ordermodel=new OrderModel();
            $result=$ordermodel->update($data);
            if($result===false){
                $this->redirect('index.php?p=Admin&c=Order&a=edit',$ordermodel->getError(),3);
            }else{
                $this->redirect('index.php?p=Admin&c=Order&a=lists');
            }
        }else{
            $id=$_GET['id'];
            $ordermodel=new OrderModel();
            $rows=$ordermodel->getOne($id);
            $this->assign($rows);
            $this->display('edit');
        }
    }
}