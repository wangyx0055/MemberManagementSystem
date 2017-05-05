<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/20
 * Time: 10:29
 */
class ArticleController extends PlatformController{

    public function lists(){
        //1.接收数据
        //2.处理数据
        //a.获取商品所有数据
        $articlemodel = new ArticleModel();
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
        $pageResult = $articlemodel->getPage($page,$pageSize);
        //分配商品数据
        $this->assign($pageResult);
        //3.显示页面
        $this->display('lists');
    }
    public function add(){
        if($_SERVER['REQUEST_METHOD']=$_POST){
            $data=$_POST;
            $articlemodel=new ArticleModel();
            $result=$articlemodel->add($data);
            if($result===false){
                $this->redirect('index.php?p=Admin&c=Article&a=add',$articlemodel->getError(),3);
            }else{
                $this->redirect('index.php?p=Admin&c=Article&a=lists');
            }
        }else{
            $this->display('add');
        }
    }
    public function remove(){
        $id=$_GET['id'];
        $articlemodel=new ArticleModel();
        $articlemodel->remove($id);
        $this->redirect('index.php?p=Admin&c=Article&a=lists');
    }
    public function edit(){
        if($_SERVER['REQUEST_METHOD']=$_POST){
            $data=$_POST;
            $articalmodel=new ArticleModel();
            $result=$articalmodel->update($data);
            if($result===false){
                $this->redirect('index.php?p=Admin&c=Article&a=edit',$articalmodel->getError(),3);
            }else{
                $this->redirect('index.php?p=Admin&c=Article&a=lists');
            }
        }else{
            $id=$_GET['id'];
            $articalmodel=new ArticleModel();
            $rows=$articalmodel->getOne($id);
            $this->assign($rows);
            $this->display('edit');
        }
    }
    //分页的方法

}