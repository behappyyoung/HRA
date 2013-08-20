<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ypark
 * Date: 8/16/13
 * Time: 9:17 AM
 * To change this template use File | Settings | File Templates.
 */

class HRA {
    protected function getJsonData($url, $para, $post=true){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, $post);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = substr($output, strpos($output, '{'));
        return $output;
    }

    protected function saveInfo($data, $guid){
        if(($data=='')||($guid=='')) return false;
        $subquery = '';
        foreach($data as $key => $value){
            $subquery .= '`'.$key.'` = "'.$value.'",';
        }
        $subquery = substr($subquery, 0, -1);
        $query = 'UPDATE ' . elgg_get_config("dbprefix") . 'hra_basicinfo SET  '. $subquery .' WHERE guid = '.$guid;
        echo $query;
        $result = update_data($query);
        return $result;
    }
}