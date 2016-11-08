<?php
/**
 *
 */
class sqlHelper
{
    private $mysqli;
    //静态的变量需要配置到一个文件中,用一个函数读取进来
    private static $host="localhost";
    private static $user="";//这里填用户名
    private static $password="";//这里填密码
    private static $db="";//这里填数据库名
    function __construct()
    {
        //初始化
        $this->mysqli=new MySQLi(self::$host,self::$user,self::$password,self::$db);
        if ($this->mysqli->connect_error) {
            die("连接失败".$this->mysqli->connect_error);
        }
        $this->mysqli->query("set names utf8");
    }
    public function execute_dql($sql)
    {
        $result=$this->mysqli->query($sql) or die("操作sql失败".$this->mysqli->error);
        return $result;
    }
    public function execute_dml($sql)
    {
        $result = $this->mysqli->query($sql);
        if (!$result) {
            return 0;//操作失败
        } else if($this->mysqli->affected_rows>0){
            return 1;//操作成功
        }else return 2;//没有行数受到影响
    }

    public function close()
    {
        $this->mysqli->close();
    }
}
?>