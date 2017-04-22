<?php
/**
 * DB类
 * 三私一公
 * 私有的静态成员属性
 * 私有的构造方法
 * 私有的克隆方法
 * 公有的静态创建对象的方法
 */
class DB{
    private $host;//主机
    private $username;//用户名称
    private $password;//密码
    private $dbname;//数据库名
    private $port;//端口号
    private $charset;//字符集

    private $link;//保存数据库连接

    private static $db;//私有的静态成员属性
    //初始化属性值
    private function __construct($config){
        $this->host = isset($config['host']) ? $config['host'] : '127.0.0.1';
        $this->username = isset($config['username']) ? $config['username'] : 'root';
        $this->password = $config['password'];
        $this->dbname = $config['dbname'];
        $this->port = isset($config['port']) ? $config['port'] : 3306;
        $this->charset = isset($config['charset']) ? $config['charset'] : 'utf8';

        //连接数据库
        $this->connect();
        //设置字符集
        $this->setCharset();
        //执行sql
    }

    /**
     * 共有的静态成员方法
     */
    public static function getInstance($config){
//        if(!self::$db instanceof DB){
//            self::$db = new DB($config);
//        }
//        return self::$db;

        if(!self::$db instanceof self){//使用self代替 自己DB
            self::$db = new self($config);
        }
        return self::$db;
    }

    //连接数据库
    public function connect(){
        $this->link = mysqli_connect($this->host,$this->username,$this->password,$this->dbname,
            $this->port,$this->charset);
        if($this->link === false){
            die(
                '数据库连接失败'.'<br />'.
                '错误信息：'.mysqli_connect_error().'<br />'.
                '错误编号：'.mysqli_connect_errno()
            );
        }
    }
    //设置字符集
    public function setCharset(){
        $result = mysqli_set_charset($this->link,$this->charset);
        if($result === false){
            die(
                '设置字符集失败'.'<br />'.
                '错误信息：'.mysqli_error($this->link).'<br />'.
                '错误编号：'.mysqli_errno($this->link)
            );
        }
    }

    /**
     * 专门用于执行sql语句
     * @param $sql
     * @return bool|mysqli_result 返回 结果集 或者 bool
     */
    public function query($sql){
        $rs = mysqli_query($this->link,$sql);
        if($rs === false){
            die(
                '执行sql语句失败'.'<br />'.
                '错误信息：'.mysqli_error($this->link).'<br />'.
                '错误编号：'.mysqli_errno($this->link).'<br />'.
                'SQL语句：'.$sql
            );
        }
        return $rs;
    }

    /**
     * 获取多条结果
     * @param $sql
     * @return array 二维数组
     */
    public function fetchAll($sql){
        //1.执行sql
        $rs = $this->query($sql);

        //2.从结果集中取出数据，组成二维数组
        $rows=[];
        while($row = mysqli_fetch_assoc($rs)){
            $rows[]=$row;
        }
        return $rows;
    }

    /**
     * 执行sql获取一行数据
     * @param $sql
     * @return array
     */
    public function fetchRow($sql){
        //1.执行sql
        $rs = $this->fetchAll($sql);
        //2.返回一行数据
        return empty($rs) ? null : $rs[0];
    }

    /**
     * 执行sql，返回 第一行第一例的值
     * @param $sql
     * @return array|null
     */
    public function fetchColumn($sql){
        //1.执行sql
        $row = $this->fetchRow($sql);
        //2.返回一行的第一例的值
        return empty($row) ? null : array_values($row)[0];
    }

    ////关闭数据库连接
    public function __destruct(){
        mysqli_close($this->link);
    }
    //私有的克隆方法
    private function __clone(){

    }

    /**
     * 该方法 对象 序列化的时候 自动调用 返回需要序列化的 属性
     * @return array
     */
    public function __sleep()
    {
        return ['host','username','password','dbname','port','charset'];
    }

    public function __wakeup()
    {
        //初始化连接数据库，设置字符集
        $this->connect();
        $this->setCharset();
    }

    /**
     * 转移sql参数
     */
    public function escape_sq($data){
        return mysqli_real_escape_string($this->link,$data);
    }
}



