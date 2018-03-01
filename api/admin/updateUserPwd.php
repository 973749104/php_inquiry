<?php
/**
 * Created by PhpStorm.
 * User: LHX
 * Date: 2018/3/1
 * Time: 19:23
 */
require_once '../../utils/adminClass.php';
//获取传递的数据
$postData = file_get_contents("php://input");
//数据处理
$postResult = json_decode($postData, true);
//数据提取
$userId = $postResult['userId'];
$userPwd = md5($postResult['userPwd']);

$admin = new adminClass();
$res = $admin->editUserPwd($userId, $userPwd);
echo json_encode($res);