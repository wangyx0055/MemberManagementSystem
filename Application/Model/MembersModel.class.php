<?php
class MembersModel extends Model{
    //根据条件获取数据
    public function getAll(){
        //1.准备sql
        $sql = "select * from members";
        //2.执行sql
        $rows = $this->db->fetchAll($sql);
        //3.返回结果
        return $rows;
    }
    //添加套餐功能
    public function add($data){
        $data['password']=md5( $data['password']);
        //1.准备sql
        $sql = "insert into members(`username`,`password`,`realname`,sex,telephone,last_login,`last_loginip`,group_id,`photo`,`thumb_photo`) VALUES ('{$data['username']}','{$data['password']}','{$data['realname']}','{$data['sex']}',{$data['telephone']},{$data['last_login']},'{$data['last_loginip']}',{$data['group_id']},'{$data['photo']}','{$data['thumb_photo']}')";
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
            $sql_count = "select count(*) from members WHERE $condition limit 1";
        }else{
            $sql_count = "select count(*) from members limit 1";
        }
        $count = $this->db->fetchColumn($sql_count);
        //获取总页数
        $totalPage = ceil($count/$pageSize);//ceil 向上取整
        //获取当前页的数据
        $page = $page > $totalPage ? $totalPage : $page;
        $start = ($page-1)*$pageSize;
        $start = $start <0 ? 0 : $start;
        if(!empty($condition)){
            $sql_rows = "select * from members WHERE $condition order by member_id  asc limit {$start},{$pageSize}";
        }else{
            $sql_rows = "select * from members order by member_id asc limit {$start},{$pageSize}";
        }
        $rows = $this->db->fetchAll($sql_rows);
        return ['rows'=>$rows,'count'=>$count,'pageSize'=>$pageSize,'page'=>$page,'totalPage'=>$totalPage];
    }
    //删除功能
    public function delete($id){
        //1.准备sql
        $sql5="select amount from histories WHERE member_id=$id";
        $rs=$this->db->fetchRow($sql5);
        if (empty($rs)){
        $sql2 = "delete from members WHERE member_id=$id";
        //2.执行sql
        $rs=$this->db->query($sql2);
        return $rs;}else{
            return false;
        }
    }
    public function update($data){
        $data['last_loginip']=$_SERVER['REMOTE_ADDR'];
        $data['password']=md5( $data['password']);
        $sql="update members set ";
        $sql.="`username`='{$data['username']}',";
        $sql.="`password`='{$data['password']}',";
        $sql.="`realname`='{$data['realname']}',";
        $sql.="sex='{$data['sex']}',";
        $sql.="telephone='{$data['telephone']}',";
        $sql.="last_login='{$data['last_login']}',";
        $sql.="`last_loginip`='{$data['last_loginip']}',";
        $sql.="group_id='{$data['group_id']}',";
        $sql.="is_admin='{$data['is_admin']}',";
        $sql.="`photo`='{$data['photo']}',";
        $sql.="`thumb_photo`='{$data['thumb_photo']}' ";
        $sql.="where member_id={$data['old_id']}";
        $result = $this->db->query($sql);
        //3.返回结果
        return $result;
    }
    public function getOne($id){
        $sql="select * from members WHERE member_id=$id";
        $row=$this->db->fetchRow($sql);
        return $row;
    }
}