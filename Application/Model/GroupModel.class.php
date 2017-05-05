<?php
class GroupModel extends Model{
    public function getGroupList(){
        $sql="select * from `group`";
        $group=$this->db->fetchAll($sql);
        return $group;
    }
    public function getOne($id){
        $sql="select * from `group` WHERE group_id=$id";
        $row=$this->db->fetchRow($sql);
        return $row;
    }
    public function add($data){
        $sql="insert into `group` (`group_id`,`name`) values('','{$data["name"]}')";
        $this->db->query($sql);
        return true;
    }
    public function delete($id){
        $sql="delete from `group` WHERE group_id=$id";
        $this->db->query($sql);
        return true;
    }
    public function update($data){
        $sql="update `group` set group_id={$data['group_id']},`name`='{$data['name']}' where group_id={$data['edit_id']}";
        $this->db->query($sql);
        return true;
    }
}