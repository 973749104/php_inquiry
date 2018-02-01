<?php
/**
 * Created by PhpStorm.
 * User: RQ
 * Date: 2018/1/29
 * Time: 17:34
 */
require_once dirname(__FILE__).'/config.php';
require_once dirname(__FILE__).'/doSql.php';

class userClass{
//    连接数据库
    private function connSql(){
        $db = new DataBase(constant('mysql_host'), constant('mysql_userName'), constant('mysql_pwd'), constant('mysql_dbName'));
//        选择数据表
        $db->set_table('yj_user');
        return $db;
    }
//    用户登录
    public function checkLogin($userName, $userPwd){
        $db = self::connSql();
        $res = $db->where('u_name= "'.$userName.'" and u_pwd="'.md5($userPwd).'"')->find();
//        对结果判断
        if(count($res) > 0){
//            获取用户信息
            $fields = 'u_name,u_points';
            $option = 'where u_name = "'.$userName.'"';
            $userInfo = $db->get_fields($fields,$option);
//            数据处理
            $res = array('userName'=> $userInfo[0]['u_name'], "userPoint"=>$userInfo[0]['u_points']);
            return $res;
        }else{
            return false;
        }
    }
}