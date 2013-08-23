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
        if($post){
            curl_setopt($ch, CURLOPT_POST,1);
            curl_setopt($ch,CURLOPT_POSTFIELDS, $para);
        }else{
            curl_setopt($ch, CURLOPT_POST,0);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = substr($output, strpos($output, '{'));
        return $output;
    }

    protected function saveInfo($data, $table){
        if($data=='') return false;
        $keys = implode('`,`',array_keys($data));
        $values =  implode('","',array_values($data));
        $query = 'INSERT INTO '. elgg_get_config("dbprefix") . $table. ' (`' . $keys.'` ) VALUES ("'. $values.'")';
        $result = insert_data($query);
        return $result;
    }

    protected function updateInfo($guid,$data, $table){
        if(($data=='')||($guid=='')) return false;
        $subquery = '';
        foreach($data as $key => $value){
            $subquery .= '`'.$key.'` = "'.$value.'",';
        }
        $subquery = substr($subquery, 0, -1);
        $query = 'UPDATE ' . elgg_get_config("dbprefix") . $table. ' SET  '. $subquery .' WHERE guid = '.$guid;
        $result = update_data($query);
        return $result;
    }

    protected function updateHra($guid, $hraid, $data, $table){
        if(($data=='')||($guid=='')||($hraid=='')) return false;
        $subquery = '';
        foreach($data as $key => $value){
            $subquery .= '`'.$key.'` = "'.$value.'",';
        }
        $subquery = substr($subquery, 0, -1);
        $query = 'UPDATE ' . elgg_get_config("dbprefix") . $table. ' SET  '. $subquery .' WHERE guid = '.$guid .' AND hra_id ='.$hraid;
        $result = update_data($query);
        return $result;
    }

    protected function updateQuestion($qid, $data, $table){
        if(($data=='')||($qid=='')) return false;
        $subquery = '';
        foreach($data as $key => $value){
            $subquery .= '`'.$key.'` = "'.$value.'",';
        }
        $subquery = substr($subquery, 0, -1);
        $query = 'UPDATE ' . elgg_get_config("dbprefix") . $table. ' SET  '. $subquery .' WHERE qid = '.$qid ;
        $result = update_data($query);
        return $result;
    }


}