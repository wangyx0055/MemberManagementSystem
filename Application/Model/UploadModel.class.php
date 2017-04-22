<?php

class UploadModel extends Model
{
    public function upload($fileinfo,$dir){
        //文件上传判断
        if($fileinfo['error'] != 0){
            $this->error = "文件上传失败！";
            return false;
        }
        //判断文件上传类型
        $allow_types = ['image/jpeg','image/png','image/gif'];
        if(!in_array($fileinfo['type'],$allow_types)){
            $this->error = "文件类型错误。";
            return false;
        }
        //判断上传文件大小
        $max_size = 2*1024*1024;
        if($fileinfo['size'] > $max_size){
            $this->error = "文件大小超过指定大小！";
            return false;
        }
        //判断是否是通过 http post上传
        if(!is_uploaded_file($fileinfo['tmp_name'])){
            $this->error = "文件不是通过浏览器上传。";
            return false;
        }
        //分目录存储
        //使用年月日来区分目录
        $dirname = UPLOADS_PATH.$dir.date("Ymd").'/';
        //创建文件夹
        if(!is_dir($dirname)){
            mkdir($dirname,0777,true);//true 迭代创建 如果文件不存在自动创建
        }
        $filename = $dirname.uniqid("IT_").strrchr($fileinfo['name'],'.');
        //判断移动文件是否成功
        if(move_uploaded_file($fileinfo['tmp_name'],$filename)){
            return str_replace(UPLOADS_PATH,'',$filename);//子字符串替换
        }else{
            $this->error = "移动文件失败！";
            return false;
        }
    }
}