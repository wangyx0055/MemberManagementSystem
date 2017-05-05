<?php
/**
 * 定义项目路径常量 规定所有路径以 /
 */
defined("DS") or define('DS', DIRECTORY_SEPARATOR);//将目录分隔符变短
//defined("ROOT_PATH") or define("ROOT_PATH",__DIR__.DS);
defined("ROOT_PATH") or define("ROOT_PATH", dirname($_SERVER['SCRIPT_FILENAME']) . DS);
defined("APP_PATH") or define("APP_PATH", ROOT_PATH . 'Application' . DS);//application的路径
defined("FRAME_PATH") or define("FRAME_PATH", ROOT_PATH . 'Framework' . DS);//framework的路径
defined("PUBLIC_PATH") or define("PUBLIC_PATH", ROOT_PATH . 'Public' . DS);//public的路径
defined("UPLOADS_PATH") or define("UPLOADS_PATH", ROOT_PATH . 'Uploads' . DS);//uploads的路径
defined("CONFIG_PATH") or define("CONFIG_PATH", APP_PATH . 'Config' . DS);//config的路径
defined("CONTROLLER_PATH") or define("CONTROLLER_PATH", APP_PATH . 'Controller' . DS);//Controller的路径
defined("MODEL_PATH") or define("MODEL_PATH", APP_PATH . 'Model' . DS);//Model的路径
defined("VIEW_PATH") or define("VIEW_PATH", APP_PATH . 'View' . DS);//View的路径
defined("TOOLS_PATH") or define("TOOLS_PATH", FRAME_PATH . 'Tools' . DS);//Tools的路径

//引入配置文件
$GLOBALS['config'] = require CONFIG_PATH . "application.config.php";


//1.接收url请求参数
$a = isset($_GET['a']) ? $_GET['a'] : $GLOBALS['config']['default']['default_action'];
$c = isset($_GET['c']) ? $_GET['c'] : $GLOBALS['config']['default']['default_controller'];
$p = isset($_GET['p']) ? $_GET['p'] : $GLOBALS['config']['default']['default_platform'];


//定义当前控制器所在路径
defined("CURRENT_CONTROLLER_PATH") or define("CURRENT_CONTROLLER_PATH", CONTROLLER_PATH . $p . DS);
//定义当前视图文件所在路径
defined("CURRENT_VIEW_PATH") or define("CURRENT_VIEW_PATH", VIEW_PATH . $p . DS . $c . DS);

//2.引入控制器类，创建控制器对象
//require CURRENT_CONTROLLER_PATH."{$c}Controller.class.php";
$class_name = $c . 'Controller';

define('ACTION_NAME',$a);
define('CONTROLLER_NAME',$c);
define('PLATFORM_NAME',$p);
$controller = new $class_name();

//3.调用控制器对象上的方法
$controller->$a();


//实现类的自动加载
function __autoload($class_name)
{
    $classMapping = [
        'DB' => TOOLS_PATH . "DB.class.php",
        'Model' => FRAME_PATH . "Model.class.php",
        'Controller'=>FRAME_PATH. "Controller.class.php"
    ];
    if (isset($classMapping[$class_name])) {//特殊类
        require $classMapping[$class_name];
    } elseif (substr($class_name, -10) == "Controller") {//控制器
        require CURRENT_CONTROLLER_PATH . "{$class_name}.class.php";
    } elseif (substr($class_name, -5) == "Model") {//模型
        require MODEL_PATH . "{$class_name}.class.php";
    }
}