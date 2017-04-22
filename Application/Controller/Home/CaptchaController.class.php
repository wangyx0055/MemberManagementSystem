<?php

//验证码控制器
class CaptchaController extends Controller
{
    //生成验证码
    public function index(){
        $this->generate();
    }
    //生成随机码
    private function makeCode($num=4){
        $str = "ABCDEFGHJKLMNPQRSTUVWXYZ23456789";
        $str = str_shuffle($str);
        return substr($str,0,$num);
    }
    //生成随机验证码
    private function generate(){
        //1.随机码值
        $random_code = $this->makeCode(4);
        //将随机码保存到session中
        @session_start();
        $_SESSION['random_code'] = $random_code;
        //2.随机背景
        //使用已经存在的图片创建画布
        $captcha_path = PUBLIC_PATH."Admin/captcha/captcha_bg".mt_rand(1,5).".jpg";
        $imageinfo = getimagesize($captcha_path);//获取图片信息
        list($width,$height) = $imageinfo;
        $image = imagecreatefromjpeg($captcha_path);
        //3.白色边框
        //选择颜色
        $white = imagecolorallocate($image,255, 255, 255);
        //画边框
        imagerectangle($image,0,0,$width-1,$height-1,$white);
        //4.字体随机白色黑色
        $black = imagecolorallocate($image,0,0,0);
        imagestring($image,5,$width/3,$height/6,$random_code,mt_rand(0,1) ? $white:$black);
        //5.输出验证码
        header("Content-Type: ".$imageinfo['mime'].";charset=utf-8");
        imagejpeg($image);
        imagedestroy($image);
    }
}