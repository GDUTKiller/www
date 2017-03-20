<?php
define('ROOT', dirname(__DIR__));
class Ymysqli {
    public $link;

    public function __construct() {
        $this->conn();
    }

    /**
    * 连接数据库
    *
    * @return resource 连接成功,返回连接数据库的资源
    */
    private function conn() {
        $cfg = require('./config.php');
        $this->link = new mysqli($cfg['host'], $cfg['user'], $cfg['pwd'], $cfg['db']);
        if($this->link->connect_error) {
            die("数据库连接失败" . $this->link->connect_error);
        }
        $this->link->query('set names '.$cfg['charset']);
        return true;
    }

    /**
    * 查询的函数
    * @return mixed resoure/bool
    */
    private function query($sql) {
        $rs = $this->link->query($sql);
        if($rs) {
            $this->log($sql);
        } else {
            $this->log($sql . '\n' . $rs->error);
        }
        return $rs;
    }

    /**
    * log日志记录功能
    * @param str $str 待记录的字符串
    */
    protected function log($str) {
        $filename = ROOT . '/log/' . date('Ymd') . '.txt';
        $log = "-----------------------------------------\n".date('Y/m/d H:i:s') . "\n" . $str . "\n" . "-----------------------------------------\n\n";
        file_put_contents($filename, $log, FILE_APPEND);
    }

    /**
    * select 查询多行数据
    *
    * @param str $sql select 待查询的sql语句
    * @return mixed select 查询成功,返回二维数组,失败返回false
    */
    public function getAll($sql) {
        $rs = $this->query($sql);
        if(!$rs) {
            return false;
        }

        $data = array();
        while($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }

    /**
    * select 取出一行数据
    *
    * @param str $sql 待查询的sql语句
    * @return arr/false 查询成功 返回一个一维数组
    */
    public function getRow($sql) {
        $rs = $this->query($sql);
        if(!$rs) {
            return false;
        } else {
            return $rs->fetch_assoc();
        }
    }

    /**
    * select 查询返回一个结果
    *
    * @param str $sql 待查询的select语句
    * @return mixed 成功,返回结果,失败返回false
    */
    public function getOne($sql) {
        $rs = $this->query($sql);
        if(!$rs) {
            return false;
        } else {
            return $rs->fetch_row()[0];
        }
    }

    /**
    * 自动拼接insert 和 update sql语句,并且调用query() 去执行sql
    *
    * @param str $table 表名
    * @param arr $data 接收到的数据,一维数组
    * @param str $act 动作 默认为'insert'
    * @param str $where 防止update更改时少加where条件
    * @return bool insert 或者update 插入成功或失败
    */
    public function exec($table , $data , $act='insert' , $where=0) {
        if($act == 'insert') {
            $sql = "insert into $table (";
            $sql .= implode(',' , array_keys($data)) . ") values ('";
            $sql .= implode("','" , array_values($data)) . "')";
            return $this->query($sql);
        } else if ($act == 'update') {
            $sql = "update $table set ";
            foreach($data as $k=>$v) {
                $sql .= $k . "='" . $v . "',";
            }

            $sql = rtrim($sql , ',') . " where ".$where;
            return $this->query($sql);
        }
    }

    /**
    * 取得上一步insert 操作产生的主键id
    */
    public function getLastId() {
        return $this->link->insert_id;
    }
}

$mysqli = new Ymysqli();
?>