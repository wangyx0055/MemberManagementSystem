<?php
class GroupController extends PlatformController{
    public function lists(){
        $groupModel=new GroupModel();
        $rows=$groupModel->getGroupList();
        $this->assign('rows',$rows);
        $this->display('lists');
    }
    public function add(){
        if($_SERVER['REQUEST_METHOD']==='POST'){
            //1.接收数据
            $data = $_POST;
            //2.处理数据
            $groupModel = new GroupModel();
            $groupModel->add($data);
            //3.显示页面
            $this->redirect("index.php?p=Admin&c=Group&a=lists","添加成功！",3);
        }else{
            $this->display('add');
        }
    }
//修改
    public function edit(){
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $data=$_POST;
            $groupModel=new GroupModel();
           $result=$groupModel->update($data);
            if($result){
                $this->redirect('index.php?p=Admin&c=Group&a=lists',"修改成功！",3);
            }
        }else{
            $id=$_GET['id'];
            $groupModel=new GroupModel();
            $row=$groupModel->getOne($id);
            $this->assign($row);
            $this->display('edit');
        }
    }
    public function delete(){
        $id=$_GET['id'];
        $groupModel=new GroupModel();
        $result=$groupModel->delete($id);
        if($result){
            $this->redirect("index.php?p=Admin&c=Group&a=lists","删除成功！",3);
        }
    }
}