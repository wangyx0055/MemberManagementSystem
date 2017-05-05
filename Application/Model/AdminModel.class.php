<?php
class AdminModel extends Model{
    //验证用户名和密码是否正确
    public function check($username,$password){
        //1.将传入的密码进行md5加密
        $password = md5($password);
        //2.到数据库中查询是否有对应得用户和密码
        $sql = "select * from members WHERE username='{$username}' and password='{$password}' limit 1";
        $row = $this->db->fetchRow($sql);
        if(empty($row)){
            $this->error = "用户名或者密码错误！";
            return false;
        }else{
            return $row;
        }
    }
    public function User_check($username,$password){
        //1.将传入的密码进行md5加密
        $password = md5($password);
        //2.到数据库中查询是否有对应得用户和密码
        $sql = "select * from users WHERE username='{$username}' and password='{$password}' limit 1";
        $row = $this->db->fetchRow($sql);
        if(empty($row)){
            $this->error = "用户名或者密码错误！";
            return false;
        }else{
            return $row;
        }
    }
    //验证cookie中的id和password
    public function checkByCookie($id,$password){
        //1.根据id到数据库中查询对应得用户信息
            $sql = "select * from members WHERE member_id={$id} limit 1";
            $row = $this->db->fetchRow($sql);
        //2.将用户信息中的password取出来，再次加密，与传入的进行比对
            if(empty($row)){//如果返回的结果为空
                return false;
            }
            $password_in_db = $row['password'];
            $password_in_db = md5($password_in_db."_admin");
            if($password == $password_in_db){//比对密码
                return $row;
            }else{
                return false;
            }
    }
    public function User_checkByCookie($id,$password){
        //1.根据id到数据库中查询对应得用户信息
        $sql = "select * from users WHERE users_id={$id} limit 1";
        $row = $this->db->fetchRow($sql);
        //2.将用户信息中的password取出来，再次加密，与传入的进行比对
        if(empty($row)){//如果返回的结果为空
            return false;
        }
        $password_in_db = $row['password'];
        $password_in_db = md5($password_in_db."_admin");
        if($password == $password_in_db){//比对密码
            return $row;
        }else{
            return false;
        }
    }
}