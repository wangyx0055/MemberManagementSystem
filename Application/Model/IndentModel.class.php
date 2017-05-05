<?php


class IndentModel extends Model{
    public function getPage($page,$pageSize){
        //获取总条数
        $sql_count = "select count(*) from indent limit 1";
        $count = $this->db->fetchColumn($sql_count);
        //获取总页数
        $totalPage = ceil($count/$pageSize);//ceil 向上取整
        //获取当前页的数据
        $page = $page > $totalPage ? $totalPage : $page;
        $start = ($page-1)*$pageSize;
        $start = $start <0 ? 0 : $start;
        $sql_rows = "select * from indent order by ind_id asc limit {$start},{$pageSize}";
        $rows = $this->db->fetchAll($sql_rows);
        return ['rows'=>$rows,'count'=>$count,'pageSize'=>$pageSize,'page'=>$page,'totalPage'=>$totalPage];
    }
    public function getAll(){
        $sql="select * from indent";
        $rows=$this->db->fetchAll($sql);
        return $rows;
    }

    public function add($data,$random){
        $time=date("Y-m-d H:i:s");
        $time=strtotime($time);
        $sql_1="select * from users";
        $users_id=$this->db->fetchColumn($sql_1);

        $sql="insert into `indent` (num,user_id,`time`,`name`,tel,address) values('$random',$users_id,$time,'{$data["name"]}','{$data["tel"]}','{$data["dizhi"]}')";
        $row=$this->db->query($sql);
        return $row;
    }

    public function fahuo_f($id){
        $sql="update indent set statu='1' where ind_id=$id";
        $row=$this->db->query($sql);
        return $row;
    }



}