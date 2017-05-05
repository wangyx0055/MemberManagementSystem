<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/20
 * Time: 11:39
 */
class ArticleModel extends Model{
    public function getAll(){
   $sql="select * from article";
        $rows=$this->db->fetchAll($sql);
        return $rows;
    }
    public function add($data){
        $data['time']=time();
        $data['start']=strtotime($data['start']);
        $data['end']=strtotime($data['end']);
        $sql="insert into article(title,content,start,end,time) VALUES ('{$data['title']}','{$data['content']}','{$data['start']}','{$data['end']}','{$data['time']}')";
        $result=$this->db->query($sql);
        if($result===false){
            $this->error='添加失败';
            return false;
        }else{
            return $result;
        }
    }
    public function remove($id){
        $sql="delete from article where article_id = {$id}";
        $this->db->query($sql);
    }
    public function getOne($id){
        $sql="select * from article where article_id={$id} limit 1";
        $rows=$this->db->fetchRow($sql);
        $rows['start']=date('Y-d-m',$rows['start']);
        $rows['end']=date('Y-d-m',$rows['end']);
        return $rows;
    }
    public function update($data){
        $data['time']=time();
        $data['start']=strtotime($data['start']);
        $data['end']=strtotime($data['end']);
        $sql = "update article set title='{$data['title']}',content='{$data['content']}',start='{$data['start']}',end='{$data['end']}',time='{$data['time']}' WHERE article_id={$data['article_id']}";
        $result=$this->db->query($sql);
        if($result===false){
            $this->error='更新失败';
            return false;
        }else{
            return $result;
        }
    }
    public function getPage($page,$pageSize){
        //获取总条数
        $sql_count = "select count(*) from article limit 1";
        $count = $this->db->fetchColumn($sql_count);
        //获取总页数
        $totalPage = ceil($count/$pageSize);//ceil 向上取整
        //获取当前页的数据
        $page = $page > $totalPage ? $totalPage : $page;
        $start = ($page-1)*$pageSize;
        $start = $start <0 ? 0 : $start;
        $sql_rows = "select * from article order by article_id asc limit {$start},{$pageSize}";
        $rows = $this->db->fetchAll($sql_rows);
        return ['rows'=>$rows,'count'=>$count,'pageSize'=>$pageSize,'page'=>$page,'totalPage'=>$totalPage];
    }
}