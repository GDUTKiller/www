<?php
/****
布尔教育 高端PHP培训
培  训: http://www.itbool.com
论  坛: http://www.zixue.it
****/



/**
* 连接数据库
*
* @return resource 连接成功,返回连接数据库的资源
*/
function mConn() {
	static $conn = null;
	if($conn === null) {
		$cfg = require(ROOT . '/lib/config.php');
		$conn = new mysqli($cfg['host'], $cfg['user'], $cfg['pwd'], $cfg['db']);
		$conn->query('set names '.$cfg['charset']);
		if($conn->connect_error) {
			die("连接数据库失败" . $conn->connect_error);
		}
		//echo "连接成功";
	}

	return $conn;
}

/**
* 查询的函数
* @return mixed resoure/bool
*/
function mQuery($sql) {
	$rs  = mConn()->query($sql);
	if($rs) {
		mLog($sql);
	} else {
		mLog($sql. "\n" . mConn()->error);
	}

	return $rs;
}


/**
* log日志记录功能
* @param str $str 待记录的字符串
*/
function mLog($str) {
	$filename = ROOT . '/log/' . date('Ymd') . '.txt';
	$log = "-----------------------------------------\n".date('Y/m/d H:i:s') . "\n" . $str . "\n" . "-----------------------------------------\n\n";
	return file_put_contents($filename, $log , FILE_APPEND);
}


/**
* select 查询多行数据
*
* @param str $sql select 待查询的sql语句
* @return mixed select 查询成功,返回二维数组,失败返回false
*/

function mGetAll($sql) {
	$rs = mQuery($sql);
	if(!$rs) {
		return false;
	}

	$data = array();
	while($row = $rs->fetch_assoc()) {
		$data[] = $row;
	}

	return $data;
}

/*$sql = "select * from cat";
print_r(mGetAll($sql));
echo "<br>";*/


/**
* select 取出一行数据
*
* @param str $sql 待查询的sql语句
* @return arr/false 查询成功 返回一个一维数组
*/

function mGetRow($sql) {
	$rs = mQuery($sql);
	if(!$rs) {
		return false;
	}

	//return mysqli_fetch_assoc($rs);
	return $rs->fetch_assoc();
}

/*$sql = "select * from cat where cat_id=1";
print_r(mGetRow($sql));
echo "<br>";*/

/**
* select 查询返回一个结果
*
* @param str $sql 待查询的select语句
* @return mixed 成功,返回结果,失败返回false
*/
function mGetOne($sql) {
	$rs = mQuery($sql);
	if(!$rs) {
		return false;
	}

	return $rs->fetch_row()[0];
}
/*$sql = "select count(*) from art where cat_id=1";
echo mGetOne($sql);
echo "<br>";*/

/**
* 自动拼接insert 和 update sql语句,并且调用mQuery() 去执行sql
*
* @param str $table 表名
* @param arr $data 接收到的数据,一维数组
* @param str $act 动作 默认为'insert'
* @param str $where 防止update更改时少加where条件
* @return bool insert 或者update 插入成功或失败
*/

function mExec($table , $data , $act='insert' , $where=0) {
	if($act == 'insert') {
		$sql = "insert into $table (";
		$sql .= implode(',' , array_keys($data)) . ") values ('";
		$sql .= implode("','" , array_values($data)) . "')";
		return mQuery($sql);
	} else if ($act == 'update') {
		$sql = "update $table set ";
		foreach($data as $k=>$v) {
			$sql .= $k . "='" . $v . "',";
		}

		$sql = rtrim($sql , ',') . " where ".$where;
		return mQuery($sql);
	}
}
//$data = array('title'=>'今天的空气' , 'content'=>'空气质量优' , 'pubtime'=>12345678,'author'=>'baibai');
//insert into art (title,content,pubtime,author) values ('今天的空气','空气质量优','12345678','baibai');
//update art set title='今天的空气',conte='空气质量优',pubtime='12345678',author='baibai' where art_id=1;
//cho mExec('art' , $data , 'update' , 'art_id=1');;
//insert into cat (id,catname) values (5 , 'test');

/**
* 取得上一步insert 操作产生的主键id
*/
function getLastId() {
	//return mysqli_insert_id(mConn());
	return mConn()->insert_id;
}

?>


