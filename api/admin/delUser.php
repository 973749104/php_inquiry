<?php
/**
 * Created by PhpStorm.
 * User: LHX
 * Date: 2018/3/1
 * Time: 14:45
 */
require_once '../../utils/adminClass.php';

$userId = $_GET['userId'];

$adminClass = new adminClass();

$res = $adminClass->delUser($userId);

echo json_encode($res);