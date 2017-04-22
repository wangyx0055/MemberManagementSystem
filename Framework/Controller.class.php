<?php


abstract class Controller
{
    private $data = [];

    /**
     * 该方法专门用于加载视图页面，需要传入视图文件的名称
     * @param $template 视图文件的名称
     */
    public function display($template){
//        $GLOBALS['rows'] = 'xxx'; 全局变量是可以随时修改，不好
        //通过多个属性，将值分配到页面
//        var_dump($this->rows);
/*        $rows = $this->data['rows'];
        $name = $this->data['name'];
        $age = $this->data['age'];*/
        /**
         * 将关联数组中的值取出，放到对应得键名的变量中
         */
        extract($this->data);
//        var_dump($this->data);
//        var_dump($rows);
        require CURRENT_VIEW_PATH.$template.'.html';
    }

    /**
     * 专业用于将数据分配到页面
     * @param $key 如果只传一个值，并且是一维数组，可以在页面通过一维数组的键取得其值
     * @param $value
     */
    public function assign($key,$value = ''){
        if(is_array($key)){
            $this->data = array_merge($this->data,$key);
        }else{
            $this->data[$key] = $value;
        }
    }


    /**
     * 专业跳转方法
     * @param 跳转的url $url
     * @param string $msg 提示信息
     * @param int $times 等待时间
     */
    public function redirect($url,$msg = '',$times = 0){
        /* if($times){//提示信息并等待一定时间后跳转
             echo "<h1>{$msg}</h1>";
             header("Refresh: {$times};{$url}");//延迟
         }else{//直接跳转
             header("Location: {$url}");
         }*/
        if($times){//提示信息并等待一定时间后跳转
            echo "<h1>{$msg}</h1>";
        }
        header("Refresh: {$times};{$url}");//延迟
        exit;//必须退出，如果不退出代码将继续执行
    }
}