## QunarSpider Introduction

[this project must run at cli](http://www.baidu.com/)

**QunarSpider is a Web spider project written in php.*.

## Installation

First, clone the antvel repository into your local folder using:

```
git clone https://github.com/luozijian/QunarSpider.git
```

Next, you will need to update your **inc_config.php** where in **config**  folder

```
<?php

$GLOBALS['config']['db'] = array(
    'host'  => '127.0.0.1',
    'port'  => 3306,
    'user'  => 'root',//这里填数据库用户名
    'pass'  => '',//这里填数据库密码
    'name'  => '',//这里填数据库名
);

//redis如果不需要启用redis则无需修改
$GLOBALS['config']['redis'] = array(
    'host'      => '127.0.0.1',
    'port'      => 6379,
    'pass'      => '',
    'prefix'    => 'phpspider',
    'timeout'   => 30,
);

include "inc_mimetype.php";

```

After update your **inc_config.php** file, be sure to create your database and import the `2016-11-4.sql ` file

Then, you can test if the QunarSpider work normal ,like so:

```
php -f qunar_hotel.php
```

After run all these commands you should be able to look at your QunarSpider version running in your machine without problems.

### Usage

First, import the sql file in you local mysql

eg:`phpspider_2016-12-13.sql`

Next, you need to update you **sqlHelper.php** where in **demo** folder

    <?php

    /**

     *

     */

    class sqlHelper
    {
    private $mysqli;
    //静态的变量需要配置到一个文件中,用一个函数读取进来
    private static $host="localhost";
    private static $user="";// 这里填数据库用户名
    private static $password="";// 这里填数据库密码
    private static $db="phpspider";// 这里填数据库名
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
        } else if($this->mysqli->affected_rows > 0){
            return 1;//操作成功
        }else return 2;//没有行数受到影响
    }
    
    public function close()
    {
        $this->mysqli->close();
    }}
    ?>


Now, you can run **shell.js** in **demo** folder on the browser console

### Demo Information

- `Demo:` Interface: https://github.com/luozijian/QunarSpider

### Contact

You can communicate with luozijian using the following mediums:

- [Email](https://mail.qq.com/) 564774252@qq.com for questions