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
    protected function saveInfo(){

    }
}