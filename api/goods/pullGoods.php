<?php
/**
 * Created by PhpStorm.
 * User: RQ
 * Date: 2018/1/29
 * Time: 17:32
 * 拉取商品数据
 */
require_once '../../utils/goodsClass.php';
//    获取tab
    $tab = $_GET['tab'];
//    实例化对象
    $good = new goodsClass();
    $res = $good->pull_NoBuy($tab);
    echo json_encode($res);