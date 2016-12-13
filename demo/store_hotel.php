<?php
//引入文件
require_once "sqlHelper.php";
header("Content-type=text/html;charset=utf8");
date_default_timezone_set('PRC');
if(isset($_GET['id'])){
    //获取所有数据
    $data['id'] = $_GET['id'];
    $data['name'] = $_GET['name'];
    if(isset($_GET['goods_count'])){
        $data['goods_count'] = $_GET['goods_count'];
        $data['mids_count'] = $_GET['mids_count'];
        $data['bads_count'] = $_GET['bads_count'];
    }else{
        $data['goods_count'] = 0;
        $data['mids_count'] = 0;
        $data['bads_count'] = 0;
    }
    $data['goods_rate'] = $_GET['goods_rate'];

    $data['comment_count'] = $data['goods_count'] + $data['mids_count'] + $data['bads_count'];
    $data['created_at'] = date('y-m-d h:i:s',time());

    //插入操作
    $sql_insert = "insert into qunar_hotels values (
                          '{$data['id']}',
                          '{$data['name']}',
                          '{$data['comment_count']}',
                          '{$data['goods_rate']}',
                          '{$data['goods_count']}',
                          '{$data['bads_count']}',
                          '{$data['mids_count']}',
                          '{$data['created_at']}'
                      )";
    $sqlHelper = new sqlHelper();
    $result = $sqlHelper->execute_dml($sql_insert);
    unset($data);
    if ($result==0) {
        //注意重复插入也算失败
        $res = ['res' => '插入酒店失败'];
    } else if($result==1){
        $res = ['res' => '插入酒店成功'];
    }else if($result==2) {
        $res = ['res' => '没有受影响行数'];
    }else{
        $res = ['res' => 'unknown fault'];
    }
    //释放资源
//        $sqlHelper->close();

    echo $_GET['jsoncallback'] . '(' . json_encode($res) . ')';
}else{
    $results = array("res" => "error");
    echo $_GET['jsoncallback'] . '(' . json_encode($results) . ')';
}