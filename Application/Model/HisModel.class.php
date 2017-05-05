<?php

class HisModel extends Model
{
    public function getAll(){
        $sql="select * from histories";
        $rows=$this->db->fetchAll($sql);
        return $rows;
    }
    public function getOne($id){
        //1.准备sql
        $sql = "select * from histories WHERE history_id={$id}";
        //2.执行sql
        $row = $this->db->fetchRow($sql);
        //3.返回结果
        return $row;
    }
    public function getAll2($id){
        $sql="select * from histories WHERE users_id={$id}";
        $rows=$this->db->fetchAll($sql);
        return $rows;
    }
    public function Oneget(){
        //1.准备sqlplan_id={$id}
        $sql = "select * from plans";
        //2.执行sql
        $plans = $this->db->fetchAll($sql);

        //1.准备sqlplan_id={$id}
        $sql = "select * from members";
        //2.执行sql
        $members = $this->db->fetchAll($sql);
        //3.返回结果
        return ['plans'=>$plans,'members'=>$members];
    }


//充值
    public function update($data){
        $time=date("Y-m-d H:i:s");
        $time=strtotime($time);
        //1.准备sql
        $sql_1="select * from jie WHERE cj<={$data['jine']} ORDER BY cj DESC  limit 1";
        $row = $this->db->fetchRow($sql_1);
        $char=$row['zj']+$data['jine'];
        $sql_2="insert into histories (users_id,`time`,`type`,amount,remainder) VALUES ({$data['user_id']},$time,1,'{$data['jine']}',remainder+{$char})";
        $rows=$this->db->query($sql_2);

        //统计积分总数根据充值总数计算
        $sql="SELECT sum(`histories`.amount) as total FROM `histories` WHERE `histories`.users_id={$data['user_id']} and `histories`.type=1 GROUP BY `histories`.users_id ";
        $rows2=$this->db->fetchrow($sql);
        $sql2="update users set acc={$rows2['total']} where users_id={$data['user_id']}";
        $this->db->query($sql2);

        $sql_3 = "update users set money=money+{$char} where users_id={$data['user_id']}";
        //2.执行sql
        $result = $this->db->query($sql_3);
        if($result){
            $sql1="SELECT sum(amount) as total FROM `histories` WHERE users_id={$data['user_id']}";
            $total=$this->db->fetchColumn($sql1);
                $sql2="select * from vip";
                $rowss=$this->db->fetchAll($sql2);
                $vip='';
                if($total>=$rowss[4]['InMoney']){
                    $vip=5;
                }
                if($total>=$rowss[3]['InMoney'] && $total<$rowss[4]['InMoney']){
                    $vip=4;
                }
                if($total>=$rowss[2]['InMoney'] && $total<$rowss[3]['InMoney']){
                    $vip=3;
                }
                if($total>=$rowss[1]['InMoney'] && $total<$rowss[2]['InMoney']){
                    $vip=2;
                }
                if($total>=$rowss[0]['InMoney'] && $total<$rowss[1]['InMoney']){
                    $vip=1;
                }
                if($total>=0 && $total<$rowss[0]['InMoney']){
                    $vip=0;
                }
            }
            $this->db->query("update users set is_vip={$vip} WHERE users_id={$data['user_id']}");

        //3.返回
        return $result;
    }
    //消费
    public function xpdate($data){

        $time=date("Y-m-d H:i:s");
        $time=strtotime($time);

        //根据套餐id到套餐表查询套餐对应得金额
        $sql_2="select money from plans WHERE plan_id={$data['plan_id']}";
        $money=$this->db->fetchColumn($sql_2);

        //从用户表查询用户级别 id
        $sql_1="select is_vip from users WHERE users_id={$data['user_id']}";
        $is_vip=$this->db->fetchColumn($sql_1);
        //根据vip_id 查询对应的打折 折扣
        $vip = 1;
        if($is_vip>0){
            $zhekou = $this->db->fetchColumn("select zhekou from vip WHERE vip_id={$is_vip}");
            $vip = $zhekou;
        }
        //根据传入的代金券号码，查询对应得代金券金额
        $code_money = 0;
        if(!empty($data['code'])){
            $sql_3="select money from codes WHERE code='{$data['code']}' and user_id={$data['user_id']}";
            $code_money_in_db=$this->db->fetchColumn($sql_3);
            if($code_money_in_db > 0){
                $code_money = $code_money_in_db;
            }
        }
        //计算消费公式
        $xiaofei = $money*$vip;
        //判断余额是否小于消费金额，如果小于不能消费
        $yue = $this->db->fetchColumn('select money from users WHERE users_id='.$data['user_id']);
        //代金券的多次使用

        if($code_money>=$xiaofei){
            //如果代金券金额大于消费金额
            //用户余额不用减，只需要更新消费记录和代金券金额
            $sql = "update codes set money='money-{$xiaofei}',status=1 where code='{$data['code']}'";
             $this->db->query($sql);
            //记录消费记录
        }else{
            //如果代金券金额小于消费金额

            $char=$xiaofei-$code_money;
            $sql_4="insert into histories (users_id,member_id,`time`,`type`,amount,remainder) VALUES ({$data['user_id']},{$data['member_id']},$time,0,'{$char}',{$yue}-{$char})";
            $rws=$this->db->query($sql_4);
            //判断余额是否小于消费金额，如果小于不能消费
            if($yue < $char){
                $this->error = "余额不足";
                return false;
            }
            //更新用户余额
            $sql = "update users set money=money-{$char} where users_id={$data['user_id']}";
            $result = $this->db->query($sql);
            //更新代金券状态为已经使用
            //记录消费记录
        }
    }

    public function delete($id){
        //1.准备sql
        $sql = "delete from histories WHERE  history_id={$id}";
        //2.执行sql
        $result = $this->db->query($sql);
        //3.返回结果
        return $result;
    }
    public function getPage($page,$pageSize){
        //获取总条数
        $sql_count = "select count(*) from histories limit 1";
        $count = $this->db->fetchColumn($sql_count);
        //获取总页数
        $totalPage = ceil($count/$pageSize);//ceil 向上取整
        //获取当前页的数据
        $page = $page > $totalPage ? $totalPage : $page;
        $start = ($page-1)*$pageSize;
        $start = $start <0 ? 0 : $start;
        $sql_rows = "select * from histories order by history_id asc limit {$start},{$pageSize}";
        $rows = $this->db->fetchAll($sql_rows);
        return ['rows'=>$rows,'count'=>$count,'pageSize'=>$pageSize,'page'=>$page,'totalPage'=>$totalPage];
    }
    public function getPage2($id,$page,$pageSize){
        //获取总条数
        $sql_count = "select count(*) from histories WHERE users_id={$id} limit 1";
        $count = $this->db->fetchColumn($sql_count);
        //获取总页数
        $totalPage = ceil($count/$pageSize);//ceil 向上取整
        //获取当前页的数据
        $page = $page > $totalPage ? $totalPage : $page;
        $start = ($page-1)*$pageSize;
        $start = $start <0 ? 0 : $start;
        $sql_rows = "select * from histories WHERE users_id={$id} order by history_id asc limit {$start},{$pageSize}";
        $rows = $this->db->fetchAll($sql_rows);
        return ['rows'=>$rows,'count'=>$count,'pageSize'=>$pageSize,'page'=>$page,'totalPage'=>$totalPage];
    }
 public function Amount(){
    $sql="SELECT sum(`histories`.amount) as total,`histories`.users_id,`users`.username FROM `histories`,`users` WHERE `histories`.users_id=`users`.users_id and `histories`.type=0 GROUP BY `histories`.users_id ORDER BY total desc LIMIT 3";
    $rows3=$this->db->fetchAll($sql);
    return $rows3;
 }
    public function Amount2(){
        $sql="SELECT sum(`histories`.amount) as total,`histories`.users_id,`users`.username FROM `histories`,`users` WHERE `histories`.users_id=`users`.users_id and `histories`.type=1 GROUP BY `histories`.users_id ORDER BY total desc LIMIT 3";
        $rows2=$this->db->fetchAll($sql);
        return $rows2;
    }
    public function Amount1(){
        $sql="SELECT sum(`histories`.amount) as total,`histories`.member_id,`members`.username FROM `histories`,`members` WHERE `histories`.member_id=`members`.member_id  GROUP BY `histories`.member_id ORDER BY total desc LIMIT 3";
        $rows1=$this->db->fetchAll($sql);
        return $rows1;
    }
}



