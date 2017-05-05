<?php


class CzgzController extends Controller{
    //增加充值规则
    public function lists(){
        $czgzModel = new CzgzModel;
        $data = $czgzModel->getAll();
        $this->assign('rows', $data);
        $this->display('lists');
    }
    public function adcsave(){
        $data = $_POST;
        //2.处理数据
        //调用模型来保存数据
        $czgzModel = new CzgzModel();
        $czgzModel->abcs($data);
        //3.显示页面
        $this->redirect('index.php?p=Admin&c=Czgz&a=lists');
    }
//修改规则
    public function edit(){
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            //1.接收请求参数
            $data = $_POST;
            //2.处理数据
            //调用模型来根据id更新数据
            $czgzModel = new CzgzModel();
            $czgzModel->xgdate($data);
            //3.显示页面
            $this->redirect('index.php?p=Admin&c=Czgz&a=lists');
        } else {
            //1.接收请求参数
            $id = $_GET['id'];
            //2.处理数据
            //调用模型来根据id查询数据
            $czgzModel = new CzgzModel;
            $row = $czgzModel->getOne($id);
            //3.显示页面
            $this->assign('data',$row);
            $this->display('edit');
        }
    }
    public function add(){
        $this->display('add');
    }
    public function del()
    {
        //1.接收请求参数
        $id = $_GET['id'];
        //2.处理数据
        //调用模型来保存数据.根据id删除一行数据
        $czgzModel = new CzgzModel();
        $czgzModel->delete($id);
        //3.显示页面
        $this->redirect('index.php?p=Admin&c=Czgz&a=lists');
    }

    public function page(){
        //1.接收数据
        //2.处理数据
        //a.获取商品所有数据
        $czgzModel = new CzgzModel();
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
        $pageResult = $czgzModel->getPage($page,$pageSize);
        //分配商品数据
        $this->assign($pageResult);
        //3.显示页面
        $this->display('lists');
    }
}