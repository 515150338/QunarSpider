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

### Demo Information

- `Demo:` Interface: 

### Contact

You can communicate with luozijian using the following mediums:

- [Email](https://mail.qq.com/) 564774252@qq.com for questions