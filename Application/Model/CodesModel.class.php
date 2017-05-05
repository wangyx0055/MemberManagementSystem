<?php
class CodesModel extends Model{
    public function getCodesList(){
        $sql="select * from `codes`";
        $group=$this->db->fetchAll($sql);
        return $group;
    }
    public function generate(){
        $string ='ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code=substr(str_shuffle($string),0,11);
        return $code;
    }
    public function getOne($id){
        $sql="select * from `codes` WHERE code_id=$id";
        $row=$this->db->fetchRow($sql);
        return $row;
    }
    public function add($data){
        $data['status']=isset($data["status"])?$data['status']:0;
        $sql="insert into `codes` (`code_id`,`code`,`user_id`,`money`,`status`) values('','{$data["code"]}',{$data['user_id']},{$data['money']},{$data['status']})";
        $this->db->query($sql);
        return true;
    }
    public function delete($id){
        $sql="delete from `codes` WHERE code_id=$id";
        $this->db->query($sql);
        return true;
    }
    public function update($data){
        $sql="update `codes` set code_id={$data['code_id']},`code`='{$data['code']}',`user_id`={$data['user_id']},`money`={$data['money']},`status`={$data['status']} where code_id={$data['edit_id']}";
        $this->db->query($sql);
        return true;
    }
}