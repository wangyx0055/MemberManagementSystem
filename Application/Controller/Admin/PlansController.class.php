<?php

class PlansController extends PlatformController//继承平台控制器
{
    public function index(){
        //1.接收数据
        //2.处理数据
        //a.获取套餐所有数据
        $plansModel = new PlansModel();
        $rows = $plansModel->getAll();
        //分配套餐数据
        $this->assign('row',$rows);
        //3.显示页面
        $this->display('lists');
    }
    //分页的方法
    public function page(){
        //1.接收数据
        //2.处理数据
        //a.获取套餐所有数据
        $plansModel = new PlansModel();
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
        $pageResult = $plansModel->getPage($page,$pageSize);
        //分配商品数据
        $this->assign($pageResult);
        //3.显示页面
        $this->display('lists');
    }
    //添加功能
    public function add(){
        if($_SERVER['REQUEST_METHOD'] == "POST"){//判断上传方式是否为post
            //1.接收数据
            $data = $_POST;
            //2.处理数据
            $plansModel = new PlansModel();
            $plansModel->add($data);
            //3.显示页面
            $this->redirect('index.php?p=Admin&c=Plans&a=page');
        }else{
            //3.显示页面
            $this->display('add');
        }
    }
    //删除功能
    public function delete(){
        //1.接收数据
        $id = $_GET['id'];
        //2.处理数据
        $plansModel = new PlansModel();
        $plansModel->delete($id);
        //3.显示
        $this->redirect('index.php?p=Admin&c=Plans&a=page');
    }
    //展示修改页面，因为是修改所以需要展示原有的数据
    public function show_update(){
        //1.接收数据
        $id = $_GET['id'];
        //2.处理数据
        $plansModel = new PlansModel();
        $rows=$plansModel->show_update($id);
        $this->assign("rows",$rows);
        //3.显示
        $this->display('update');
    }

    //保存修改功能
    public function update(){
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            //1.接收数据
            $data = $_POST;
            //2.处理数据
            $plansModel = new PlansModel();
            $plansModel->update($data);
            //3.显示页面
            $this->redirect('index.php?p=Admin&c=Plans&a=page');
        }else{
            //3.显示页面
            $this->display('update');
        }
    }
}