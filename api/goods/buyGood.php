<?php
/**
 * Created by PhpStorm.
 * User: RQ
 * Date: 2018/1/30
 * Time: 14:43
 * 购买商品
 */
require_once '../../utils/goodsClass.php';
require_once '../../utils/exportExcel.php';
//    获取提交的ID
    $postResult = file_get_contents("php://input");
    $postData = json_decode($postResult, true);
//    数据处理
    $goodId = array();
    foreach ($postData['goodsId'] as $key=>$value){
        foreach ($value as $goodKey=>$goodValue){
            array_push($goodId, "$goodValue");
        }
    }
//    实例化对象
    $good = new goodsClass();
//     获取用户信息
    $uPoint = $good->checkUserPoint($postData['userName']);
//    结果
    $res = array();
    if($uPoint < count($goodId)){
        $res['result'] = false;
//        用户积分不够错误码
        $res['errorCode'] = 101;
        echo json_encode($res);
        return false;
    }else{
        $res = $good->buy_Good($goodId, $postData['userName']);
//        判断返回信息
        if(!(is_array($res) ? $res['res'] : $res)){
            echo json_encode($res);
        }else{
//          处理数据  返回数据信息并下载
            $result = array('result'=>true, 'dataCode'=>$good->getGoodInfo($goodId));
//            更新用户积分
            $good->updatePoint($postData['userName'], $uPoint - count($goodId));
            echo json_encode($result);
        }
    }
