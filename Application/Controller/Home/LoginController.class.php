<?php

//登录控制器
class LoginController extends Controller
{
    public function login(){
        //1.接收参数
        //2.处理数据
        //3.显示页面
        $index= new IndexController();
        $index->index();
    }
    //会员验证登录
    public function User_check(){
        @session_start();
        //验证验证码，如果验证码正确才执行验证密码和用户名操作
        $captcha = $_POST['captcha'];
        // 将验证 和生成的 随机字符串都转化成小写比对，不区分大小写
        if (empty($_SESSION['random_code'])){
            $_SESSION['random_code']=0;
        }
        if(strtolower($captcha) != strtolower($_SESSION['random_code'])){//strtolower函数将所有的英文字符转化为小写方便比对，这里将session里的验证码与post传过来的验证码进行比对
            $this->redirect("index.php?p=Home&c=Index&a=index","验证码错误！",3);
        }
        //1.接收参数
        $username = $_POST['username'];
        $password = $_POST['password'];
        //2.处理数据
        $adminModel = new AdminModel();
        $result = $adminModel->User_check($username,$password);//调用check方法去验证登陆名和密码
        //3.显示页面
        if($result === false){
            $this->redirect('index.php?p=Home&c=Index&a=index',$adminModel->getError(),3);
        }else{//登录成功
            //将用户信息保存到session中
            $_SESSION['USER_INFO_user'] = $result;
            if(isset($_POST['remember'])){//如果点击了记住登录
                //保存id和密码 信息到cookie中
                setcookie('id',$result['users_id'],time()+ 7*24*3600,'/');
                //需要对password进行处理，再次加密
                $password = md5($result['password']."_admin");
                setcookie('password',$password,time()+7*24*3600,'/');
            }
            //跳转首页
            $this->redirect('index.php?p=Home&c=Order&a=about');
        }
    }
    //验证登录
    public function check(){
        @session_start();
        //验证验证码，如果验证码正确才执行验证密码和用户名操作
        $captcha = $_POST['captcha'];
        if (empty($_SESSION['random_code'])){
            $_SESSION['random_code']=0;
        }
        // 将验证 和生成的 随机字符串都转化成小写比对，不区分大小写
        if(strtolower($captcha) != strtolower($_SESSION['random_code'])){//strtolower函数将所有的英文字符转化为小写方便比对，这里将session里的验证码与post传过来的验证码进行比对
            $this->redirect("index.php?p=Home&c=Index&a=index","验证码错误！",3);
        }
        //1.接收参数
        $username = $_POST['username'];
        $password = $_POST['password'];
        //2.处理数据
        $adminModel = new AdminModel();
        $result = $adminModel->check($username,$password);//调用check方法去验证登陆名和密码
        //3.显示页面
        if($result === false){
            $this->redirect('index.php?p=Home&c=Index&a=index',$adminModel->getError(),3);
        }else{//登录成功
            //将用户信息保存到session中
            $_SESSION['USER_INFO'] = $result;
            if(isset($_POST['remember'])){//如果点击了记住登录
                //保存id和密码 信息到cookie中
                setcookie('id',$result['member_id'],time()+ 7*24*3600,'/');
                //需要对password进行处理，再次加密
                $password = md5($result['password']."_admin");
                setcookie('password',$password,time()+7*24*3600,'/');
            }
            //跳转首页
            $this->redirect('index.php?p=Admin&c=Index&a=index');
        }
    }
    //注销功能
    public function logout(){
        //删除session中的用户信息
            @session_start();
            unset($_SESSION['USER_INFO']);
        //删除cookie中的id和password
            setcookie('id',null,-1,'/');//写上路径
            setcookie('password',null,-1,'/');
        //跳转到登录页面
            $this->redirect('index.php?p=Home&c=Index&a=index',"注销成功！",3);
    }
}