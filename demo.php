<?php
/**
 * Created by PhpStorm.
 * User: LHX
 * Date: 2018/1/13
 * Time: 21:58
 */
//返回JSON数组
require_once '../../utils/exportExcel.php';
$exportExcel = new exportExcel();
$exportExcel->csv_export($result['dataCode'],$result['dataCode'][0]);