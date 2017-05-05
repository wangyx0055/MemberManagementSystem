<?php
class OrderModel extends Model
{
    public function getAll()
    {
        $sql = "select * from `order`";
        $rows = $this->db->fetchAll($sql);
        return $rows;
    }
    public function Allget()
    {
        $sql = "select * from `indent`";
        $rows = $this->db->fetchAll($sql);
        return $rows;
    }

    public function no_order($order_id)
    {
        $sql = "update `order` set status=2 where order_id={$order_id}";
        $this->db->query($sql);
    }
    public function can_order($order_id)
    {
        $sql = "update `order` set status=1 where order_id={$order_id}";
        $this->db->query($sql);
    }
    public function remove($order_id){
        $sql="delete from `order` where order_id={$order_id}";
        $this->db->query($sql);
    }
   public function getOne($order_id){
       $sql="select * from `order` where order_id={$order_id} limit 1";
       $rows=$this->db->fetchRow($sql);
       return $rows;
   }
    public function update($data){
        $sql="update `order` set reply='{$data['reply']}' where order_id='{$data['order_id']}'";
        $this->db->query($sql);
    }
    public function add($data){
        @session_start();
        $data['realname']=$_SESSION['USER_INFO_user']['realname'];
        $data['phone']=$_SESSION['USER_INFO_user']['telephone'];
        $data['user_id']=$_SESSION['USER_INFO_user']['users_id'];
        $data['date']=strtotime($data['date']);
        $data['status']=0;
        $data['reply']='';
        $sql="insert into `order`(phone,realname,barber,content,date,status,reply,user_id) VALUES ('{$data['phone']}','{$data['realname']}','{$data['barber']}','{$data['content']}','{$data['date']}','{$data['status']}','{$data['reply']}','{$data['user_id']}') ";
        $result=$this->db->query($sql);
        if($result===false){
            $this->error='添加失败';
            return false;
        }else{
            return $result;
        }
    }
    public function getPage($page,$pageSize){
        //获取总条数
        $sql_count = "select count(*) from `order` limit 1";
        $count = $this->db->fetchColumn($sql_count);
        //获取总页数
        $totalPage = ceil($count/$pageSize);//ceil 向上取整
        //获取当前页的数据
        $page = $page > $totalPage ? $totalPage : $page;
        $start = ($page-1)*$pageSize;
        $start = $start <0 ? 0 : $start;
        $sql_rows = "select * from `order` order by order_id asc limit {$start},{$pageSize}";
        $rows = $this->db->fetchAll($sql_rows);
        return ['rows'=>$rows,'count'=>$count,'pageSize'=>$pageSize,'page'=>$page,'totalPage'=>$totalPage];
    }
    public function User_getPage($page,$pageSize){
        //获取总条数
        @session_start();
        $data=$_SESSION['USER_INFO_user']['users_id'];

        $sql_count = "select count(*) from `order` where user_id=$data limit 1";
        $count = $this->db->fetchColumn($sql_count);
        //获取总页数
        $totalPage = ceil($count/$pageSize);//ceil 向上取整
        //获取当前页的数据
        $page = $page > $totalPage ? $totalPage : $page;
        $start = ($page-1)*$pageSize;
        $start = $start <0 ? 0 : $start;
        $sql_rows = "select * from `order` where user_id=$data limit {$start},{$pageSize}";
        $rows = $this->db->fetchAll($sql_rows);
        return ['rows'=>$rows,'count'=>$count,'pageSize'=>$pageSize,'page'=>$page,'totalPage'=>$totalPage];
    }
}