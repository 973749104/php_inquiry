<?php
/**
 * Created by PhpStorm.
 * User: LHX
 * Date: 2018/3/1
 * Time: 14:11
 */
//  管理员登录
require_once '../../utils/adminClass.php';

//获取传递的数据
$postData = file_get_contents("php://input");
//数据处理
$postResult = json_decode($postData, true);
//数据提取
$adminName = $postResult['adminName'];
$adminPwd = md5($postResult['adminPwd']);
//创建admin类
$adminClass = new adminClass();

$res = $adminClass->adminLogin($adminName, $adminPwd);

echo json_encode($res);