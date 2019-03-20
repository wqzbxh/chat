<?php
use Workerman\Worker;
require_once __DIR__ . '/vendor/Workerman/Autoloader.php';

// 注意：这里与上个例子不同，使用的是websocket协议
$ws_worker = new Worker("websocket://0.0.0.0:2000");

// 启动4个进程对外提供服务
$ws_worker->count = 4;

// 当收到客户端发来的数据后返回hello $data给客户端
$ws_worker->onMessage = function($connections, $data)
{
	global $ws_worker;
    // 向客户端发送hello $data
    // $connection->send('hello ' . $data);
	$dataInfo = json_decode($data,true);
	   // 遍历当前进程所有的客户端连接，发送当前服务器的时间
	foreach($ws_worker->connections as $connection)
	{
		$connection->send($dataInfo);
	}
};

// 运行worker
Worker::runAll();