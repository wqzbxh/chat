<?php
use Workerman\Worker;
require_once __DIR__ . '/vendor/Workerman/Autoloader.php';

// 注意：这里与上个例子不同，使用的是websocket协议
$ws_worker = new Worker("websocket://0.0.0.0:2000");

// 启动4个进程对外提供服务
$ws_worker->count = 1;

// 当收到客户端发来的数据后返回hello $data给客户端
$ws_worker->onMessage = function($connection, $data)
{
	global $ws_worker;
    // $connection->send('hello ' . $data);
	$dataInfo = json_decode($data,true);//把前端的josn数字符串转为数组方便操作
	
	if($dataInfo['action_type'] == 'login'){//判断消息类型,如果是登录操作.执行下面的代码
		//设置用户信息
		$connection->uid = $dataInfo['userid'];
		$connection->username = $dataInfo['username'];
		$data_arr = json_encode([
			'username' => $dataInfo['username'],
			'text' => "进入聊天室",
			'action_type' => "login",
		]);
	   // 遍历当前进程所有的客户端连接，
		foreach($ws_worker->connections as $connection)
		{
			//给每个连接客户端发送消息
			$connection->send($data_arr);
		}
	}
	if($dataInfo['action_type'] == 'senAllMsg'){//给所有用户发送消息
	    foreach($ws_worker->connections as $con)
	    {
		    // 给所有用户发送用户 当前用户发送的信息
			$send_data = [
				'action_type' => 'senAllMsg',
				'my_msg' => 0,
				'userid' => $connection->uid,
				'username' => $connection->username,//
				'content' => $dataInfo['content'],
			];
	    	if ($connection->uid == $con->uid) {
	    		$send_data['my_msg'] = 1;//这个是给自己推的一个消息
	    	}
	    	$con->send(json_encode($send_data));
	    }
	}

};

$ws_worker->onConnect = function($connection)
{
	global $ws_worker,$user_count;
	$user_count++;
    // 遍历当前进程所有的客户端连接，发送当前服务器的时间
    foreach($ws_worker->connections as $connection)
    {
	    // 给所用用户广播当前在线人数
		$send_data = json_encode([
			'action_type' => 'online_user_count',
			'online_user_count' => $user_count,
		]);
        $connection->send($send_data);
    }
};

// 用户断开链接
$ws_worker->onClose = function($connection)
{
	global $ws_worker,$user_count;
	$user_count = $user_count-1;
    // 遍历当前进程所有的客户端连接，发送当前服务器的时间
    foreach($ws_worker->connections as $con)
    {
	    // 给所用用户广播用户退出
		$send_data = json_encode([
			'action_type' => 'user_on_close',
			'username' => $connection->username,
			'text' => '已经离开']);
		$con->send($send_data);

	    // 给所用用户广播当前在线人数
		$online_user_count_send_data = json_encode([
			'action_type' => 'online_user_count',
			'online_user_count' => $user_count,
		]);
        $con->send($online_user_count_send_data);
    }
};

// 运行worker
Worker::runAll();