<?php
//引入文件
require_once "sqlHelper.php";
header("Content-type=text/html;charset=utf8");
date_default_timezone_set('PRC');
if(isset($_GET['id'])){
    //获取所有数据
    $data['id'] = $_GET['id'];
    $data['hotel_id'] = $_GET['hotel_id'];
    $data['usernickname'] = $_GET['usernickname'];
    $data['userlevel'] = $_GET['userlevel'];
    if(isset($_GET['userstat'])&&is_array($_GET['userstat'])){
        $data['userstat'] = implode(',',$_GET['userstat']);
    }else{
        $data['userstat'] = '';
    }


    $flag = preg_match('/\d+篇点评/',$data['userstat'],$matches);
    if($flag){
        $data['comment_count'] = rtrim($matches[0],'篇点评');
    }else{
        $data['comment_count'] = 0;
    }
    $flag = preg_match('/\d+篇砖家/',$data['userstat'],$matches);
    if($flag){
        $data['specialist_comment_count'] = rtrim($matches[0],'篇砖家');
    }else{
        $data['specialist_comment_count'] = 0;
    }
    $flag = preg_match('/\d+个城市/',$data['userstat'],$matches);
    if($flag){
        $data['track_cities'] = rtrim($matches[0],'个城市');
    }else{
        $data['track_cities'] = 0;
    }

    $data['title'] = $_GET['title'];

    if($_GET['like_count']){
        preg_match('/\d+/',$_GET['like_count'],$matches);
        $data['like_count'] = $matches[0];
    }else{
        $data['like_count'] = 0;
    }
    if($_GET['reply_count']){
        preg_match('/\d+/',$_GET['reply_count'],$matches);
        $data['reply_count'] = $matches[0];
    }else{
        $data['reply_count'] = 0;
    }

    if(isset($_GET['star'])){
        $data['star'] = $_GET['star'];
    }else{
        $data['star'] = 0;
    }
    $data['comment'] = $_GET['comment'];

    if(isset($_GET['checkin_time'])){
        $data['checkin_time'] = $_GET['checkin_time'];
    }else{
        $data['checkin_time'] = '';
    }
    if(isset($_GET['checkin_reason'])){
        $data['checkin_reason'] = $_GET['checkin_reason'];
    }else{
        $data['checkin_reason'] = '';
    }

    $data['from'] = $_GET['from'];
    $data['created_at'] = date('y-m-d h:i:s',time());

    //插入操作
    $sql_insert = "insert into users values (
                      '{$data['id']}',
                      '{$data['hotel_id']}',
                      '{$data['usernickname']}',
                      '{$data['userlevel']}',
                      '{$data['userstat']}',
                      '{$data['comment_count']}',
                      '{$data['specialist_comment_count']}',
                      '{$data['track_cities']}',
                      '{$data['title']}',
                      '{$data['like_count']}',
                      '{$data['reply_count']}',
                      '{$data['star']}',
                      '{$data['comment']}',
                      '{$data['checkin_time']}',
                      '{$data['checkin_reason']}',
                      '{$data['from']}',
                      '{$data['created_at']}'
                  )";
    $sqlHelper = new sqlHelper();
    $result = $sqlHelper->execute_dml($sql_insert);
    unset($data);
    if ($result==0) {
        //注意重复插入也算失败
        $res = ['res' => '失败'];
    } else if($result==1){
        $res = ['res' => '成功'];
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