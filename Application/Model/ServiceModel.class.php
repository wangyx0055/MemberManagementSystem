<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/24
 * Time: 12:08
 */
class ServiceModel extends Model
{
//添加套餐功能
    public function add($data,$random){
//        var_dump($data);exit;
        @session_start();
        $time=date("Y-m-d H:i:s");
        $time=strtotime($time);
        $users_id=$_SESSION['USER_INFO_user']['users_id'];
        if(empty($data['tel'])){
            $this->error = "电话不能为空！";
            return false;
        }
        if(empty($data['address'])){
            $this->error = "地址不能为空！";
            return false;
        }
        $mark=$data['need_mark'];
        $sql3="select acc from users WHERE users_id=$users_id";
        $acc=$this->db->fetchRow($sql3);

        //1.准备sql
        if (!($acc['acc']<$mark)){
            $sql2="update users set acc=acc-$mark WHERE users_id=$users_id";
            $this->db->query($sql2);

            $sql="insert into `indent` (num,user_id,`time`,`name`,tel,address) values('$random',$users_id,$time,{$data["product_name"]},{$data["tel"]},'{$data["address"]}')";
            //2.执行sql
            $result = $this->db->query($sql);

            //3.返回结果
            return $result;
        }else{
            $this->error = "积分不足";
            return false;
        }
    }
}