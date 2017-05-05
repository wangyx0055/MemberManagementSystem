<?php
class CodesController extends PlatformController{
    public function lists(){
        $codesModel=new CodesModel();
        $rows=$codesModel->getCodesList();
        $this->assign('rows',$rows);
        $this->display('lists');
    }
    public function generateCode(){
        $codesModel=new CodesModel();
        $code=$codesModel->generate();
        $this->assign('code',$code);
    }
    public function add(){
        if($_SERVER['REQUEST_METHOD']==='POST'){
            //1.接收数据
            $data = $_POST;
            //2.处理数据
            $codesModel = new CodesModel();
            $codesModel->add($data);
            //3.显示页面
            $this->redirect("index.php?p=Admin&c=Codes&a=lists","添加成功！",3);
        }else{
            $this->generateCode();
            $this->display('add');
        }
    }
//修改
    public function edit(){
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $data=$_POST;
            $codesModel=new CodesModel();
           $result=$codesModel->update($data);
            if($result){
                $this->redirect('index.php?p=Admin&c=Codes&a=lists',"修改成功！",3);
            }
        }else{
            $id=$_GET['id'];
            $codesModel=new CodesModel();
            $row=$codesModel->getOne($id);
            $this->assign($row);
            $this->display('edit');
        }
    }
    public function delete(){
        $id=$_GET['id'];
        $codesModel=new CodesModel();
        $result=$codesModel->delete($id);
        if($result){
            $this->redirect("index.php?p=Admin&c=Codes&a=lists","删除成功！",3);
        }
    }
}