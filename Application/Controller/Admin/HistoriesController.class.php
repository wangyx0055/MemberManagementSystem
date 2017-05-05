<?php

class HistoriesController extends Controller{


    public function topup()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            //1.接收请求参数
            $data = $_POST;
            //2.处理数据
            //调用模型来根据id更新数据
            $hisModel = new HisModel();
            $hisModel->update($data);
            //3.显示页面
            $this->redirect('index.php?p=Admin&c=Users&a=lists');
        } else {
            //1.接收请求参数
            $user_id = $_GET['id'];
            //2.处理数据
            //调用模型来根据id查询数据
           $this->assign("user_id",$user_id);
            $this->display('topup');
        }
    }

//消费
    public function contion(){
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            //1.接收请求参数
            $data = $_POST;
            //2.处理数据
            //调用模型来根据id更新数据
            $hisModel = new HisModel();
            $result = $hisModel->xpdate($data);
            if($result===false){
                //3.显示页面
                $this->redirect('index.php?p=Admin&c=Histories&a=contion&id='.$data['user_id'],$hisModel->getError(),3);
            }
            //3.显示页面
            $this->redirect('index.php?p=Admin&c=Users&a=lists');
        } else {
            //1.接收请求参数
            $id = $_GET['id'];
            //2.处理数据
            //调用模型来根据id查询数据
            $hisModel = new HisModel;
            $data = $hisModel->Oneget($id);
            //3.显示页面
            $this->assign($data);
            $this->assign("user_id",$id);
            $this->display('contion');
        }
    }


    public function lists(){

        $hisModel=new HisModel;
        $data=$hisModel->getAll();
        $this->assign('rows', $data);
        $this->display('lists');
    }

    public function contentlists(){
        $id=$_GET['id'];
        //1.接收数据
        //2.处理数据
        //a.获取商品所有数据
        $hisModel = new HisModel();
        /**
         * 完成分页，需要的数据
         *  1.当前页的所有数据
         *  2.总条数
         *  3.每页显示条数
         *  4.当前页码
         *  5.总页数
         */
        $page = isset($_GET['page']) ? $_GET['page']:1;
        $pageSize = 3;//规定单个分页显示的数据条数
        $pageResult = $hisModel->getPage2($id,$page,$pageSize);
        //分配商品数据
        $this->assign($pageResult);
        $hisModel=new HisModel;
        $data=$hisModel->getAll2($id);
        $this->assign('rows', $data);
        $this->display('contentlists');
    }


    public function delete()
    {
        //1.接收请求参数
        $id = $_GET['id'];
        //2.处理数据
        //调用模型来保存数据.根据id删除一行数据
        $hisModel = new HisModel();
        $hisModel->delete($id);
        //3.显示页面
        $this->redirect('index.php?p=Admin&c=Histories&a=lists');
    }


    public function page(){
        //1.接收数据
        //2.处理数据
        //a.获取商品所有数据
        $hisModel = new HisModel();
        /**
         * 完成分页，需要的数据
         *  1.当前页的所有数据
         *  2.总条数
         *  3.每页显示条数
         *  4.当前页码
         *  5.总页数
         */
        $page = isset($_GET['page']) ? $_GET['page']:1;
        $pageSize = 3;//规定单个分页显示的数据条数
        $pageResult = $hisModel->getPage($page,$pageSize);
        //分配商品数据
        $this->assign($pageResult);
        //3.显示页面
        $this->display('lists');
    }
    public function add(){
        $this->display('add');
    }


}