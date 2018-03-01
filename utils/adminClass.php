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
        $res = $db->where('a_name= "'.$adminName.'" and a_pwd="'.md5($adminPwd).'"')->find();
        if(count($res)>0){
            return true;
        }else{
            return false;
        }
    }
//    查询所有用户
    public function getAllUser() {

    }
//    添加用户
    public function addUser($userName, $userPwd, $userPoints){
        $db = self::connSql('yj_user');
//       查询用户是否存在
        $where = 'u_name = "'.$userName.'"';
        if($db->where($where)->find() == true){
//            返回1101 用户已经存在
            return 1101;
        }
//      添加的data数据
        $data = array( 'u_name' => $userName, 'u_pwd' => $userPwd, 'u_points' => $userPoints);
        $count = $db->formatData($data)->insert();
        if($count > 0){
            return true;
        }else{
            return false;
        }
    }

//    修改用户积分
    public function editUserPoint($userId, $point){
        $db = self::connSql('yj_user');
        $db->where('u_id = '.$userId);
        $setMsg = 'u_points ='.$point;
        $res = $db->update($setMsg);
        if($res > 0){
            return true;
        }else{
            return false;
        }
    }

//    修改用户密码
    public function editUserPwd($userId, $userPwd){
        $db = self::connSql('yj_user');
        $db->where('u_id = '.$userId);
        $setMsg = 'u_pwd = "'.$userPwd.'"';
        $res = $db->update($setMsg);
        if($res > 0){
            return true;
        }else{
            return false;
        }
    }

//    修改用户名
    public function editUserName($userId, $userName){
        $db = self::connSql('yj_user');
        $db->where('u_id = '.$userId);
        $setMsg = 'u_name = "'.$userName.'"';
        $res = $db->update($setMsg);
        if($res > 0){
            return true;
        }else{
            return false;
        }
    }
//    删除用户
    public function delUser($userID){
        $db = self::connSql('yj_user');
        $where = 'u_id = '.$userID;
        $count = $db->where($where)->delete();
        if($count > 0){
            return true;
        }else{
            return false;
        }
    }

//    拉取所有数据
    public function putAllData() {

    }

//    查看某条数据详情
    public function checkDataInof() {

    }

//    添加数据
    public function addData(array $data){

    }
//    删除数据
    public function delData(array $data){

    }
}