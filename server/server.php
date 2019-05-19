<?php
use Workerman\Worker;
require_once __DIR__ . '/vendor/Workerman/Autoloader.php';


// 注意：这里与上个例子不同，使用的是websocket协议
$ws_worker = new Worker("websocket://0.0.0.0:2000");

//用户列表存储

// 启动4个进程对外提供服务
$ws_worker->count = 4;
// 当收到客户端发来的数据后返回hello $data给客户端
$ws_worker->onMessage = function($connection, $data)
{
	global $ws_worker,$userList,$sendUserList,$dataInfo; 
    // $connection->send('hello ' . $data);
	$dataInfo = json_decode($data,true);//把前端的josn数字符串转为数组方便操作
	
	if($dataInfo['action_type'] == 'login'){//判断消息类型,如果是登录操作.执行下面的代码
		//设置用户信息
		$connection->uid = $dataInfo['userid'];
		$connection->username = $dataInfo['username'];
		$connection->room_id = $dataInfo['room_id'];
		$userList[] = [
			'room_id' => $dataInfo['room_id'],
			'userid' => $dataInfo['userid'],
			'username' => $dataInfo['username'],
		];
		//定义过滤房间内客户端
		$sendUserList  = [];
		foreach($userList as $key => $value)
		{
			if($value['room_id'] == $dataInfo['room_id']){//如果用户登录进来A房间号 的房间, 在总的客户端中中过滤
				$sendUserList[] = $value;//存到$sendUserList中
			}
		}
		$data_arr = json_encode([
			'username' => $dataInfo['username'],
			'text' => "进入聊天室",
			'action_type' => "login",
			'iser_list' => $sendUserList,
			'online_user_count' => count($sendUserList)
		]);
	   // 遍历当前进程所有的客户端连接，
		foreach($ws_worker->connections as $conn)
		{
			//给每个连接客户端发送消息
			if($conn->room_id == $dataInfo['room_id']){
				$conn->send($data_arr);
			}
		}
	}
	if($dataInfo['action_type'] == 'senAllMsg'){//给所有用户发送消息
	
		include('database.php'); 
		if($dataInfo['type'] == 1){
			$insertSql = "INSERT INTO content (user_id,type,content,create_time,to_purpose) VALUES (".$connection->uid.", ". $dataInfo['type'].",'". $dataInfo['content']."', ".time().", ". $dataInfo['room_id'].")";
			$insertResult = mysqli_query($con, $insertSql);
		}else{
			$insertSql = "INSERT INTO content (user_id,type,content,create_time,to_purpose) VALUES (".$connection->uid.", ". $dataInfo['type'].",'". $dataInfo['content']."', ".time().", ". $dataInfo['room_id'].")";
			$insertResult = mysqli_query($con, $insertSql);
		}	
	    foreach($ws_worker->connections as $con)
	    {
		    // 给所有用户发送用户 当前用户发送的信息
			$send_data = [
				'action_type' => 'senAllMsg',
				'my_msg' => 0,
				'userid' => $connection->uid,
				'username' => $connection->username,//
				'time' => date('Y-m-d H:i:s',time()),//
				'content' => $dataInfo['content'],
			];
	    	if ($connection->uid == $con->uid) {
	    		$send_data['my_msg'] = 1;//这个是给自己推的一个消息
	    	}
			
			$insertSql = "INSERT INTO flock (belongs_id,type,userid_arr) VALUES ('".$myuserid."', '2','".$userid_arrA."')";
			$insertResult = mysqli_query($con, $insertSql);
			
			if($con->room_id ==$connection->room_id){
				$con->send(json_encode($send_data));
			}
	    }
	}

};

$ws_worker->onConnect = function($connection)
{
	global $ws_worker,$user_count,$sendUserList;
	$user_count++;
	//count($sendUserList);
    // 遍历当前进程所有的客户端连接，发送当前服务器的时间
    foreach($ws_worker->connections as $conn)
    {
	    // 给所用用户广播当前在线人数
		$send_data = json_encode([
			'action_type' => 'online_user_count',
			'online_user_count' => $user_count,
		]);
        $conn->send($send_data);
    }
};

// 用户断开链接
$ws_worker->onClose = function($connection)
{
	global $ws_worker,$user_count,$userList,$sendUserList;
	$user_count = $user_count-1;
	
	foreach($userList as $key => $value){
		if($connection->uid == $value['userid']){
			unset($userList[$key]);
		} 
	}
	
		//定义过滤房间内客户端
	$sendUserList  = [];
	foreach($userList as $key => $value)
	{
		if($value['room_id'] == $connection->room_id){//如果用户登录进来A房间号 的房间, 在总的客户端中中过滤
			$sendUserList[] = $value;//存到$sendUserList中
		}
	}
    // 遍历当前进程所有的客户端连接，发送当前服务器的时间
    foreach($ws_worker->connections as $con)
    {
	    // 给所用用户广播用户退出
		$send_data = json_encode([
			'action_type' => 'user_on_close',
			'username' => $connection->username,
			'iser_list' => $sendUserList,
			'online_user_count' => count($sendUserList),
			'text' => '已经离开']);
		if($con->room_id == $connection->room_id){
				$con->send($send_data);
			}
	    // 给所用用户广播当前在线人数
// 		$online_user_count_send_data = json_encode([
// 			'action_type' => 'online_user_count',
// 			'online_user_count' => $user_count,
// 		]);
//         $con->send($online_user_count_send_data);
    }
};

// 运行worker
Worker::runAll();