<?php

class PlansModel extends Model
{
    //根据条件获取数据
    public function getAll(){
        //1.准备sql
        $sql = "select * from plans ";
        //2.执行sql
        $rows = $this->db->fetchAll($sql);
        //3.返回结果
        return $rows;
    }
    //添加套餐功能
    public function add($data){
//        var_dump($data);exit;
        if(empty($data['name'])){
            $this->error = "套餐名不能为空！";
            return false;
        }
        if(empty($data['des'])){
            $this->error = "套餐简述不能为空！";
            return false;
        }
        if(empty($data['money'])){
            $this->error = "套餐金额不能为空！";
            return false;
        }
        if(empty($data['status'])){
            $this->error = "套餐上架状态不能为空！";
            return false;
        }
        //1.准备sql
        $sql = "insert into plans(`name`,`des`,money,status) VALUES ('{$data['name']}','{$data['des']}',{$data['money']},{$data['status']})";
        //2.执行sql
        $result = $this->db->query($sql);
        //3.返回结果
        return $result;
    }
    /**
     * 获取分页所需要的所有数据
     * 完成分页，需要的数据
     *  1.当前页的所有数据
     *  2.总条数
     *  3.每页显示条数
     *  4.当前页码
     *  5.总页数
     * 通过数组的形式返回
     */
    public function getPage($page,$pageSize){
        //获取总条数
        $sql_count = "select count(*) from plans limit 1";
        $count = $this->db->fetchColumn($sql_count);
        //获取总页数
        $totalPage = ceil($count/$pageSize);//ceil 向上取整
        //获取当前页的数据
        $page = $page > $totalPage ? $totalPage : $page;
        $start = ($page-1)*$pageSize;
        $start = $start <0 ? 0 : $start;
        $sql_rows = "select * from plans order by plan_id asc limit {$start},{$pageSize}";
        $rows = $this->db->fetchAll($sql_rows);
        return ['rows'=>$rows,'count'=>$count,'pageSize'=>$pageSize,'page'=>$page,'totalPage'=>$totalPage];
    }
    //删除功能
    public function delete($id){
        //1.准备sql
        $sql2 = "delete from plans WHERE plan_id={$id}";
        //2.执行sql
        $this->db->query($sql2);
    }
    public function show_update($id){
        //准备查询图片路径的sql
        $sql1="select * from plans WHERE plan_id={$id}";
        //执行sql
        $rows=$this->db->fetchRow($sql1);
        //3.返回结果
        return $rows;
    }
    public function update($data){
        $sql="update plans set `name`='{$data['name']}',`des`='{$data['des']}',money={$data['money']} ,status={$data['status']} where plan_id={$data['id']} ";
        $result = $this->db->query($sql);
        //3.返回结果
        return $result;
    }
}