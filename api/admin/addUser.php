<?php
/**
 * Created by PhpStorm.
 * User: RQ
 * Date: 2018/2/25
 * Time: 15:51
 * //添加用户
 */
require_once '../../utils/adminClass.php';
//获取传递的数据
$postData = file_get_contents("php://input");
//数据处理
$postResult = json_decode($postData, true);
//数值
$userName = $postResult['userName'];
$userPwd = md5($postResult['userPwd']);
$userPoints = $postResult['userPoints'];

$admin = new adminClass();
//返回结果
$res= $admin->addUser($userName, $userPwd, $userPoints);

echo json_encode($res);
