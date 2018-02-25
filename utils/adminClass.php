<?php
/**
 * Created by PhpStorm.
 * User: RQ
 * Date: 2018/2/7
 * Time: 9:46
 */
require_once dirname(__FILE__).'/config.php';
require_once dirname(__FILE__).'/doSql.php';

//管理员Api
class adminClass{
//    连接数据库
    private function connSql($table){
        $db = new DataBase(constant('mysql_host'), constant('mysql_userName'), constant('mysql_pwd'), constant('mysql_dbName'));
//        选择数据表
        $db->set_table($table);
        return $db;
    }
//    管理员登录
    public function adminLogin($adminName,$adminPwd){
        $db = self::connSql('yj_admin');
        $res = $db->where('u_name= "'.$adminName.'" and u_pwd="'.md5($adminPwd).'"')->find();
        if($res>0){
            return true;
        }else{
            return false;
        }
    }
//    添加用户
    public function addUser($userName, $userPwd, $userPoints){
        $db = self::connSql('yj_user');
//      添加的data数据
        $data = array( 'u_name' => $userName, 'u_pwd' => md5($userPwd), 'u_points' => $userPoints);
        $count = $db->formatData($data)->insert();
        if($count > 0){
            echo true;
        }else{
            echo false;
        }
    }
}