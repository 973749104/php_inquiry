<?php
/**
 * Created by PhpStorm.
 * User: RQ
 * Date: 2018/1/29
 * Time: 10:35
 * 用户登录
 */
//启动session
    session_start();
//引入doSql
require_once  '../../utils/userClass.php';
//    获取POST传递的数据
    $postResult = file_get_contents("php://input");
//    转换对象
    $postData = json_decode($postResult, true);
    if(empty($postData['userName']) || empty($postData['pwd'])){
        echo false;
        return false;
    }
    $user = new userClass();

    $res = $user->checkLogin($postData['userName'], $postData['pwd']);

    echo json_encode($res);
