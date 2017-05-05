<?php
class UsersController extends PlatformController{
    public function lists(){
        $page = isset($_GET['page']) ? $_GET['page']:1;
        $GLOBALS['page']=$page;
        if(!empty($_POST['keyword'])){
            $condition=" `realname`='{$_POST['keyword']}' ";
        }else{
            $condition='';
        }
        $pageSize = 3;//规定单个分页显示的数据条数
        $usersModel=new UsersModel();
        $pageResult = $usersModel->getPage($page,$pageSize,$condition);
        //分配商品数据
        //$rows=$pageResult['rows'];
        //$this->assign('rows',$rows);
        $this->assign($pageResult);
//        $groupLists=new groupModel();
//        $group=$groupLists->getGroupList();
//        $this->assign($group);
        //3.显示页面
        $this->display('lists');
    }
    public function edit(){
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $data=$_POST;
            if($_FILES['photo']['name']===''){
                $photos=['photo'=>'Admin/UsersImgs/default_photo.png','thumb_photo'=>'Admin/UsersImgs/default_photo.png'];
            }else{
                $photos=$this->photoUpdate('edit',$data);
            }
            foreach ($photos as $key=>$val){
                $data["$key"]=$val;
            }
            $data['last_login']=time();
            $usersModel=new UsersModel();
            $rs=$usersModel->update($data);

            $Gpage=empty($GLOBALS['page'])?0:$GLOBALS['page'];
            if ($rs==false){
                $this->redirect("index.php?p=Admin&a=lists&page=$Gpage","请填写所有字段",3);
            }
            $this->redirect("index.php?p=Admin&c=Users&a=lists&page=$Gpage","编辑成功！",3);
        }else{
            $id=$_GET['id'];
            $usersModel=new UsersModel();
            $row=$usersModel->getOne($id);
            $groupModel=new GroupModel();
            $groups=$groupModel->getGroupList();
            $this->assign('groups',$groups);
            $this->assign($row);
            $this->display('edit');
        }
    }
    //添加功能
    public function add(){
        if($_SERVER['REQUEST_METHOD']==='POST'){
            //1.接收数据
            $data = $_POST;
            $data['last_login']=time();
            $data['last_loginip'] = $_SERVER['REMOTE_ADDR'];
            if($_FILES['photo']['name']===''){
                $photos=['photo'=>'Admin/UsersImgs/default_photo.png','thumb_photo'=>'Admin/UsersImgs/default_photo.png'];
            }else{
                $photos=$this->photoUpdate('add',$data);
            }
            foreach ($photos as $key=>$val){
                $data["$key"]=$val;
            }
            //2.处理数据
            $usersModel = new UsersModel();
            $rs=$usersModel->add($data);
            if ($rs==false){
                $this->redirect("index.php?p=Admin&c=Users&a=add","请填写所有字段",3);
            }
            //3.显示页面
            $Gpage=empty($GLOBALS['page'])?0:$GLOBALS['page'];
            $this->redirect("index.php?p=Admin&c=Users&a=lists&page=$Gpage","添加成功！",3);
        }else{
            $this->display('add');
        }
    }
    //删除功能

    //展示修改页面，因为是修改所以需要展示原有的数据

    //保存修改功能
    public function photoUpdate($action,$data){
        $uploadModel=new UploadModel();
        //成功就返回图片路径，失败返回false
            $photo_path=$uploadModel->upload($_FILES['photo'],'Admin/UsersImgs/');
            if($photo_path===false){
                $this->redirect("index.php?p=Admin&c=Users&a=$action&id={$data['id']}",$uploadModel->getError(),3);
            }else{
                //商品图片上传成功后才制作缩略图，因为缩略图需要原图
                $imageModel=new ImageModel();
                //期待该方法成功返回缩略图的路径，失败返回false
                $thumb_photo=$imageModel->thumb($photo_path,80,80);
                if($thumb_photo===false){
                    $this->redirect("index.php?p=Admin&c=Users&a=$action",$imageModel->getError(),3);
                }else{
                    return ['photo'=>$photo_path,'thumb_photo'=>$thumb_photo];
                }
            }
    }
    public function delete(){
        $id=$_GET['id'];
        $usersModel=new UsersModel();
        $result=$usersModel->delete($id);
        if($result){
            $this->redirect("?p=Admin&c=Users&a=lists");
        }
    }
}