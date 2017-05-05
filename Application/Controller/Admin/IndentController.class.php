<?php


class IndentController extends Controller{
       public function lists(){
        //1.接收数据
        //2.处理数据
        //a.获取商品所有数据
           $indentModel = new IndentModel();
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
        $pageResult = $indentModel->getPage($page,$pageSize);
        //分配商品数据
        $this->assign($pageResult);
           $indentModel = new IndentModel();
           $data=$indentModel->getAll();
           $this->assign('rows', $data);
        //3.显示页面
        $this->display('lists');
    }

    public function add(){
        if($_SERVER['REQUEST_METHOD']==='POST'){
            //1.接收数据
            $data = $_POST;
            $str = "ABCDEFGHJKLMNPQRSTUVWXYZ23456789";
            $str = str_shuffle($str);
            $random =substr($str,0,9);
            //2.处理数据
            $indentModel = new IndentModel();
            $indentModel->add($data,$random);
            //3.显示页面
            $this->redirect("index.php?p=Admin&c=Indent&a=lists");
        }else{
            $this->display('add');
        }
    }

    public function fahuo(){
         $id=$_GET['id'];

        $indentModel=new IndentModel();
        $indentModel->fahuo_f($id);
//      //1.接收数据
        //2.处理数据
        //a.获取商品所有数据
        $indentModel = new IndentModel();
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
        $pageResult = $indentModel->getPage($page,$pageSize);
        //分配商品数据
        $this->assign($pageResult);
        $indentModel = new IndentModel();
        $data=$indentModel->getAll();
        $this->assign('rows', $data);
        //3.显示页面
        $this->display('lists');

    }
}