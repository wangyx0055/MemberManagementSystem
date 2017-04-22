<?php
//平台统一验证控制器
// 需要验证登录的控制器都需要继承该控制器
class PlatformController extends Controller
{
    //初始化
    public function __construct(){
        if($this->checkLogin() === false){
            $this->redirect('index.php?p=Home&c=Index&a=index',"你没有登录，请登录。",3);
        }
    }
    //验证是否登录 失败返回false
    private function checkLogin(){
        //使用session中的用户信息来判断是否登录
        @session_start();//这里加@屏蔽符号是为了屏蔽session重复开启的报错
        if(!isset($_SESSION['USER_INFO'])){
            //判断cookie中是否有id和password
            if(isset($_COOKIE['id']) && isset($_COOKIE['password'])){
                //将cookie中的id和password取出来，到数据库中进行验证
                $id = $_COOKIE['id'];
                $password = $_COOKIE['password'];
                $adminModel = new AdminModel();
                $result = $adminModel->checkByCookie($id,$password);
                if($result !== false){
                    //保存用户信息到session中
                    $_SESSION['USER_INFO'] = $result;
                    //跳转到首页
                    return true;
                }else{
                    return false;
                }
            }
            //没有登录信息，应该跳转到登录页面
            return false;
        }
    }
}