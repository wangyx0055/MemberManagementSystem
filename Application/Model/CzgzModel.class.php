<?php


class CzgzModel extends Model{
    public function getAll(){
        $sql="select * from jie";
        $rows=$this->db->fetchAll($sql);
        return $rows;
    }
    public function getOne($id){
        //1.准备sql
        $sql = "select * from jie WHERE id={$id}";
        //2.执行sql
        $row = $this->db->fetchRow($sql);
        //3.返回结果
        return $row;
    }
    //添加规则
    public function abcs($data){
        //1.准备sql
        $sql = "insert into `jie`(cj,zj) VALUES('{$data['cj']}','{$data['zj']}') ";
        //2.执行sql
        $result = $this->db->query($sql);
        //3.返回
        return $result;
    }
//修改规则
    public function xgdate($data){
        //1.准备sql
        $sql = "update jie set cj={$data['xcj']},zj={$data['xzs']} where id={$data['id']}";
        //2.执行sql
        $result = $this->db->query($sql);
        //3.返回
        return $result;
    }
    public function delete($id){
        //1.准备sql
        $sql = "delete from `jie` WHERE id={$id}";
        //2.执行sql
        $result = $this->db->query($sql);
        //3.返回结果
        return $result;
    }

    public function getPage($page,$pageSize){
        //获取总条数
        $sql_count = "select count(*) from jie limit 1";
        $count = $this->db->fetchColumn($sql_count);
        //获取总页数
        $totalPage = ceil($count/$pageSize);//ceil 向上取整
        //获取当前页的数据
        $page = $page > $totalPage ? $totalPage : $page;
        $start = ($page-1)*$pageSize;
        $start = $start <0 ? 0 : $start;
        $sql_rows = "select * from jie order by id asc limit {$start},{$pageSize}";
        $rows = $this->db->fetchAll($sql_rows);
        return ['rows'=>$rows,'count'=>$count,'pageSize'=>$pageSize,'page'=>$page,'totalPage'=>$totalPage];
    }
}