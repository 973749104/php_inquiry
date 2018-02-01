<?php
/**
 * Created by PhpStorm.
 * User: LHX
 * Date: 2018/1/26
 * Time: 16:37
 * 操作数据库类
 */
class DataBase{
//    host
    private $dbHost;
//    用户名
    private  $dbUserName;
//    密码
    private  $dbPwd;
//    数据库对象
    private $dbObj;
//    数据库名
    private  $dbName;
//    数据表信息
    private $table;
//    数据表对象
    private $tableObj;
//    错误信息
    protected $error = '';
//    数据信息
    protected $data= array();
//    查询表达式参数
    protected $options = array();
//    初始化构造
    public function __construct($dbHost, $dbUserName, $dbPwd, $dbName)
    {
        if(!isset($dbHost) || !isset($dbUserName) || !isset($dbPwd) || !isset($dbName)){
            return false;
        }else{
            $this->dbHost = $dbHost;
            $this->dbUserName = $dbUserName;
            $this->dbPwd = $dbPwd;
            $this->dbName = $dbName;
            //        连接数据库
            $dbObj = new mysqli($dbHost,$dbUserName,$dbPwd,$dbName);
            if($dbObj->connect_errno){
                $this->error = $dbObj->connect_error;
                return false;
            }else{
                $this->dbObj = $dbObj;
                return $this;
            }
        }
    }

//    错误信息
    public function error() {
        return $this->error;
    }
//    选择操作的表
    public function set_table($table) {
        $this->table = $table;
    }

//    查询表的所有数据
    public function select_table($table){
        $sql = 'select * from '.$table;
        $search_res = mysqli_query($this->dbObj, $sql);
        if($search_res){
            $this->table = $table;
            $table_data = self::query_handle($search_res);
            $this->tableObj = $table_data;
//          释放结果集
            mysqli_free_result($search_res);
            return $table_data;
        }else{
            mysqli_free_result($search_res);
            return false;
        }
    }

//    获取指定字段信息 关联筛选
    public function get_fields($field, $options = ''){
        $fields = self::param_handle($field);
        if(empty($options)){
            $sql = 'select '.$fields.' from '.$this->table;
        }else{
            $sql = 'select '.$fields.' from '.$this->table.' '.$options;
        }
        $res = mysqli_query($this->dbObj, $sql);
        $field_msg = self::query_handle($res) ;
        return $field_msg;
    }
//    根据查询表达式查询数据
    public function find() {
        $option = self::option();
        $sql = 'select * from '.$this->table.' '.$option;
        $search_res = mysqli_query($this->dbObj, $sql);
        $msg = self::query_handle($search_res);
        return $msg;
    }

//    where查询
    public function where($where) {
        $this->options['where'] = self::options_handle($where);
        return $this;
    }
//    更新语句update
    public function update($setMsg){
        $option = self::option();
        $sql = 'update '.$this->table.' set '.$setMsg.' '.$option;
        mysqli_query($this->dbObj, $sql);
//        返回影响行数
        return mysqli_affected_rows($this->dbObj);
    }
//    处理数据库返回的result
    protected function query_handle($obj){
        $res = array();
        for($i=0; $i<$obj->num_rows; $i++){
            $row = mysqli_fetch_assoc($obj);
            array_push($res, $row);
        }
        return $res;
    }
//    传入参数处理
    public function param_handle($param) {
        if(is_string($param) && !empty($param)){
            $params = $param;
        }elseif (is_array($param) && !empty($param)){
            $params = implode(',', $param);;
        }else{
            return false;
        }
        return $params;
    }

//    查询表达式参数处理
    public function options_handle($param) {
        if(is_numeric($param)){
            $option = $param;
        }elseif (is_string($param) && !empty($param) && !is_numeric($param)){
            $params = explode(',', $param);
            $option = implode(' and ', $params);
        }elseif (is_array($param) && !empty($param)){
            $params = $param;
            $arr = array();
            foreach ($params as $key=>$value){
                array_push($arr, "$key=$value");
            }
            $option = implode(' and', $arr);
        }else{
            return false;
        }
        return $option;
    }

//    查询表达式$options函数处理
    protected  function option() {
        $options = $this->options;
        $option = '';
        if(isset($options['where'])){
            $option .= 'where '.$options['where'].' ';
        }
        if(isset($options['order'])){
            $option .= 'order by '.$options['order'].' '.$options['order_type'].' ';
        }
        if(isset($options['limit'])){
            $option .= 'limit '.$options['limit'].' ';
        }
        return $option;
    }

//    关闭数据库
    public function closeDB() {
        $close = mysqli_close($this->dbObj);
        if($close){
            return true;
        }else{
            return false;
        }
    }

//    解析自构
    function  _destruct(){
        mysqli_close($this->dbObj);
    }
}

