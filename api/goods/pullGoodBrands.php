<?php
/**
 * Created by PhpStorm.
 * User: RQ
 * Date: 2018/1/30
 * Time: 14:09
 * 拉取商品品牌
 */
require_once '../../utils/goodsClass.php';
//实例化对象
    $goods = new goodsClass();
    $res = $goods->pull_Brands();
    echo json_encode($res);