<?php
/**
 * Created by PhpStorm.
 * User: RQ
 * Date: 2018/2/6
 * Time: 17:32
 */
require_once '../../utils/goodsClass.php';
    $postResult = file_get_contents("php://input");
    $postData = json_decode($postResult, true);
    $getUserPoint = new goodsClass();
    $point = $getUserPoint->checkUserPoint($postData['userName']);
    echo json_encode($point);