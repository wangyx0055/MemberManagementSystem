<?php

/**
 * 基础模型类
 * 所有模型类都需要继承该类
 */
abstract class Model
{
    protected $db;//保存db对象

    protected $error;//保存错误信息

    public function __construct(){
        //创建db对象
//        require TOOLS_PATH.'DB.class.php';
        $this->db = DB::getInstance($GLOBALS['config']['db']);
    }

    /**
     * 获取错误信息
     * @return mixed
     */
    public function getError(){
        return $this->error;
    }
}