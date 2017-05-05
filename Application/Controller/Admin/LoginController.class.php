<?php

//登录控制器
class LoginController extends Controller
{
    //注销功能
    public function logout(){
        //删除session中的用户信息
            @session_start();
            unset($_SESSION['USER_INFO']);
        //删除cookie中的id和password
            setcookie('id',null,-1,'/');//写上路径
            setcookie('password',null,-1,'/');
        //跳转到登录页面
            $this->redirect('index.php?p=Home&c=Index&a=index');
    }
}