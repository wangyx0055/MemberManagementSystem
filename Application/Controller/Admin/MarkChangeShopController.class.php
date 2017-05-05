<?php
class MarkChangeShopController extends PlatformController{
    public function lists(){
        $page = isset($_GET['page']) ? $_GET['page']:1;
        $GLOBALS['page']=$page;
        if(!empty($_POST['keyword'])){
            $condition=" `product_name`='{$_POST['keyword']}' ";
        }else{
            $condition='';
        }
        $pageSize = 3;//规定单个分页显示的数据条数
        $markChangeShopModel=new MarkChangeShopModel();
        $pageResult = $markChangeShopModel->getPage($page,$pageSize,$condition);
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
            $data['old_photo']=!empty($_POST['old_photo'])?$_POST['old_photo']:'Admin/MarkChangeShopImgs/default_photo.png';
            if($_FILES['photo']['name']===''){
                $old_photo=$data['old_photo'];
                $photos=['photo'=>$old_photo,'thumb_photo'=>'Admin/MarkChangeShopImgs/default_photo.png'];
            }else{
                $photos=$this->photoUpdate('edit',$data);
            }
            foreach ($photos as $key=>$val){
                $data["$key"]=$val;
            }
            $markChangeShopModel=new MarkChangeShopModel();
            $markChangeShopModel->update($data);
            $Gpage=empty($GLOBALS['page'])?0:$GLOBALS['page'];
            $this->redirect("index.php?p=Admin&c=MarkChangeShop&a=lists&page=$Gpage","编辑成功！",3);
        }else{
            $id=$_GET['id'];
            $markChangeShopModel=new MarkChangeShopModel();
            $row=$markChangeShopModel->getOne($id);
            $this->assign($row);
            $this->display('edit');
        }
    }
    //添加功能
    public function add(){
        if($_SERVER['REQUEST_METHOD']==='POST'){
            //1.接收数据
            $data = $_POST;
            if(empty($data['product_name'])||empty($data['product_detail'])||empty($data['needed_mark'])){
                $this->redirect("index.php?p=Admin&c=MarchangeShop&a=add","输入不能为空！",3);
            }
            if($_FILES['photo']['name']===''){
                $photos=['photo'=>'Admin/MarkChangeShopImgs/default_photo.png','thumb_photo'=>'Admin/MarkChangeShopImgs/default_photo.png'];
            }else{
                $photos=$this->photoUpdate('add',$data);
            }
            foreach ($photos as $key=>$val){
                $data["$key"]=$val;
            }
            //2.处理数据
            $markChangeShopModel = new MarkChangeShopModel();
            $markChangeShopModel->add($data);
            //3.显示页面
            $Gpage=empty($GLOBALS['page'])?0:$GLOBALS['page'];
            $this->redirect("index.php?p=Admin&c=MarkChangeShop&a=lists&page=$Gpage","添加成功！",3);
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
            $photo_path=$uploadModel->upload($_FILES['photo'],'Admin/MarkChangeShopImgs/');
            if($photo_path===false){
                $this->redirect("index.php?p=Admin&c=MarkChangeShop&a=$action&id={$data['id']}",$uploadModel->getError(),3);
            }else{
                //商品图片上传成功后才制作缩略图，因为缩略图需要原图
                $imageModel=new ImageModel();
                //期待该方法成功返回缩略图的路径，失败返回false
                $thumb_photo=$imageModel->thumb($photo_path,80,80);
                if($thumb_photo===false){
                    $this->redirect("index.php?p=Admin&c=MarkChangeShop&a=$action",$imageModel->getError(),3);
                }else{
                    return ['photo'=>$photo_path,'thumb_photo'=>$thumb_photo];
                }
            }
    }
    public function delete(){
        $id=$_GET['id'];
        $markChangeShopModel=new MarkChangeShopModel();
        $result=$markChangeShopModel->delete($id);
        if($result){
            $this->redirect("?p=Admin&c=MarkChangeShop&a=lists");
        }
    }
}