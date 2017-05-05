<?php
class MarkChangeShopModel extends Model{
    //根据条件获取数据
    public function getAll(){
        //1.准备sql
        $sql = "select * from markchangeshop";
        //2.执行sql
        $rows = $this->db->fetchAll($sql);
        //3.返回结果
        return $rows;
    }
    //添加套餐功能
    public function add($data){
        //1.准备sql
        $sql = "insert into markchangeshop(`product_name`,`product_detail`,`needed_mark`,store_amount,`photo`,`thumb_photo`) VALUES ('{$data['product_name']}','{$data['product_detail']}',{$data['needed_mark']},{$data['store_amount']},'{$data['photo']}','{$data['thumb_photo']}')";
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
    public function getPage($page,$pageSize,$condition){
        //获取总条数
        if(!empty($condition)){
            $sql_count = "select count(*) from markchangeshop WHERE $condition limit 1";
        }else{
            $sql_count = "select count(*) from markchangeshop limit 1";
        }
        $count = $this->db->fetchColumn($sql_count);
        //获取总页数
        $totalPage = ceil($count/$pageSize);//ceil 向上取整
        //获取当前页的数据
        $page = $page > $totalPage ? $totalPage : $page;
        $start = ($page-1)*$pageSize;
        $start = $start <0 ? 0 : $start;
        if(!empty($condition)){
            $sql_rows = "select * from markchangeshop WHERE $condition order by product_id  asc limit {$start},{$pageSize}";
        }else{
            $sql_rows = "select * from markchangeshop order by product_id asc limit {$start},{$pageSize}";
        }
        $rows = $this->db->fetchAll($sql_rows);
        return ['rows'=>$rows,'count'=>$count,'pageSize'=>$pageSize,'page'=>$page,'totalPage'=>$totalPage];
    }
    //删除功能
    public function delete($id){
        //1.准备sql
        $sql2 = "delete from markchangeshop WHERE product_id=$id";
        //2.执行sql
        $rs=$this->db->query($sql2);
        return $rs;
    }
    public function update($data){
        $sql="update markchangeshop set ";
        $sql.="`product_name`='{$data['product_name']}',";
        $sql.="`product_detail`='{$data['product_detail']}',";
        $sql.="`needed_mark`={$data['needed_mark']},";
        $sql.="store_amount='{$data['store_amount']}',";
        $sql.="`photo`='{$data['photo']}',";
        $sql.="`thumb_photo`='{$data['thumb_photo']}' ";
        $sql.="where product_id={$data['old_id']}";
        $result = $this->db->query($sql);
        //3.返回结果
        return $result;
    }
    public function getOne($id){
        $sql="select * from markchangeshop WHERE product_id=$id";
        $row=$this->db->fetchRow($sql);
        return $row;
    }
}