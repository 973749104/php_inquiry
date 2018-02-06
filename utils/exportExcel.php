<?php
/**
 * Created by PhpStorm.
 * User: RQ
 * Date: 2018/2/3
 * Time: 10:28
 * 导出EXCLE
 */
class exportExcel{

    public function csv_export($data = array(), $headList = array(), $fileName = 'data'){
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$fileName.'.csv"');
        header('Cache-Control: max-age=0');
//        直接输出到浏览器
        $fp = fopen('php://output', 'a');
//        输出信息
        foreach ($headList as $key=>$value){
            $headList[$key] = iconv('utf-8','GBK', $value);
        }
//        数据添加到句柄
        fputcsv($fp, $headList);
//        计数器
        $num = 0;
//每隔$limit行，刷新一下输出buffer，不要太大，也不要太小
        $limit = 10000;
//        逐行读数据
        $count = count($data);
        for($i=0;$i<$count;$i++){
            if($limit == $num){
                ob_flush();
                flush();
                $num = 0;
            }
            $row = $data[$i];
            foreach ($row as $key=>$value){
                $row[$key] = iconv('utf-8', 'GBK', $value);
            }
            return fputcsv($fp,$row);
        }
    }

}