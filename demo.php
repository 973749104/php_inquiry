<?php
/**
 * Created by PhpStorm.
 * User: LHX
 * Date: 2018/1/13
 * Time: 21:58
 */
//返回JSON数组
header('Content-type:text/json');
require './utils/config.php';
include  './utils/doSql.php';
echo '连接数据库';

$db = new DataBase(constant('mysql_host'), constant('mysql_userName'), constant('mysql_pwd'), constant('mysql_dbName'));

$table = 'ecs_delivery_order';

if($db->select_table($table)){
    print_r($db->select_table($table));
}else{
    echo '无数据';
}
