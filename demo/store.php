<?php
	//引入文件
	require_once "sqlHelper.php";
	header("Content-type=text/html;charset=utf8");
	if(isset($_GET['id'])){
		//获取所有数据
		$data['id'] = $_GET['id'];
		$data['usernickname'] = $_GET['usernickname'];
		$data['userlevel'] = $_GET['userlevel'];
		$data['userstat'] = implode(',',$_GET['userstat']);
		//插入操作
		$sql_insert = "insert into users values ('{$data['id']}','{$data['usernickname']}','{$data['userlevel']}','{$data['userstat']}')";
		$sqlHelper = new sqlHelper();
        $result = $sqlHelper->execute_dml($sql_insert);
        if ($result==0) {
            $res = ['res'=>'失败'];
        } else if($result==1){
            $res = ['res'=>'成功'];
        }else if($result==2) {
            $res = ['res'=>'没有受影响行数'];
        }
        //释放资源
//        $sqlHelper->close();
		
		echo $_GET['jsoncallback'] . '(' . json_encode($res) . ')';
	}else{
		$results = array("res" => "error"); 
		echo $_GET['jsoncallback'] . '(' . json_encode($results) . ')';
	}