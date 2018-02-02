<?php
/**
 * Created by PhpStorm.
 * User: RQ
 * Date: 2018/1/30
 * Time: 9:33
 * 商品操作类
 */
require_once dirname(__FILE__).'/config.php';
require_once dirname(__FILE__).'/doSql.php';

class goodsClass{
//    连接数据库
    private function connSql($tabel){
        $db = new DataBase(constant('mysql_host'), constant('mysql_userName'), constant('mysql_pwd'), constant('mysql_dbName'));
//        选择数据表
        $db->set_table($tabel);
        return $db;
    }


//    拉取未被购买的商品数据
    public function pull_NoBuy($model){
        $db = self::connSql('dataCode');
//        获取制定信息
        $fields = 'data_id, SN, IMEI, ECID, MLBSN, BTY';
        $option = 'where data_id in (select data_id from dataStatus where isBuy = false and model = "'.$model.'")';
        $res = $db->get_fields($fields,$option);
        return $res;
    }


//    拉取商品品牌
    public function pull_Brands(){
        $db = self::connSql('dataStatus');
//      获取指定信息
        $fields = 'model';
        $option  = 'group by model';
        $res = $db->get_fields($fields,$option);
        return $res;
    }


//    购买商品
    public function buy_Good($goodId,$userName){
        $db = self::connSql('dataStatus');
        $res = 0;
//      判断商品是否被购买
        $checkGood = self::checkGood($goodId);
        if(!(is_array($checkGood) ? $checkGood['res'] : $checkGood)){
//            返回错误码
            return $checkGood;
        }
        for($i=0;$i<count($goodId);$i++){
            $db->where('data_id ='.$goodId[$i]);
//        1为购买0为未购买
            $setMsg = 'isBuy = true,u_name = "'.$userName.'" ';
            if($db->update($setMsg) > 0){
                $res++;
            };
        }
//        返回结果
        return $res == count($goodId) ? true : false ;
    }


//      查询用户积分
    public function checkUserPoint($userID){
        $db = self::connSql('yj_user');
//      获取指定信息
        $fields = 'u_points';
        $option = 'where u_name = "'.$userID.'"';
        $res = $db->get_fields($fields,$option);
        $u_points = array_column($res, 'u_points');
        return $u_points[0];
    }


//    判定商品是否被购买
    private function checkGood($goodId){
        $db = self::connSql('dataStatus');
        for($i=0;$i<count($goodId);$i++){
          $where = 'isBuy = true and data_id='.$goodId[$i];
          $res = $db->where($where)->find();
          if(count($res) > 0){
              $arr = array("data_id"=>$goodId[$i],"res"=>false);
              return $arr;
          }
        }
        return true;
    }

//    获取购买的商品信息
    public function getGoodInfo($goodId){
        $db = self::connSql('dataCode');
        $res = array();
        for($i=0;$i<count($goodId);$i++){
            $resData = $db->where('data_id = '.$goodId[$i])->find();
            array_push($res,$resData);
        }
            return $res;
    }
}