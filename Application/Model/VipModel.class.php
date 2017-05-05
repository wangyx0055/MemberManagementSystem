<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/23
 * Time: 13:09
 */
class VipModel extends Model{
public function getAll(){
    $sql="select * from vip";
    $rows=$this->db->fetchAll($sql);
    return $rows;
}
    public function getOne($id){
        $sql="select * from vip where vip_id={$id} limit 1";
        $rows=$this->db->fetchRow($sql);
        return $rows;
    }
    public function add($data){
        $sql="insert into vip(rank,zhekou,InMoney) VALUES ('{$data['rank']}','{$data['zhekou']}','{$data['InMoney']}')";
        $result=$this->db->query($sql);
        if($result===false){
            $this->error='添加失败';
            return false;
        }else{
            return $result;
        }
    }
    public function update($data){
        $sql = "update vip set rank='{$data['rank']}',zhekou='{$data['zhekou']}',InMoney='{$data['InMoney']}' where vip_id='{$data['vip_id']}'";
        $result=$this->db->query($sql);
        if($result===false){
            $this->error='更新失败';
            return false;
        }else{
            return $result;
        }
    }
}