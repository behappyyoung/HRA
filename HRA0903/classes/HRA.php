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
        $query = 'INSERT INTO ' . $table. ' (`' . $keys.'` ) VALUES ("'. $values.'")';
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
        $query = 'UPDATE '  . $table. ' SET  '. $subquery .' WHERE elgg_user_guid = '.$guid;
        $result = update_data($query);
        return $result;
    }

    protected function updateUser($guid,$data, $table){
        if(($data=='')||($guid=='')) return false;
        $subquery = '';
        foreach($data as $key => $value){
            $subquery .= '`'.$key.'` = "'.$value.'",';
        }
        $subquery = substr($subquery, 0, -1);
        $query = 'UPDATE '  . $table. ' SET  '. $subquery .' WHERE elgg_user_guid = '.$guid;
        $result = update_data($query);
        return $result;
    }

    protected function updateStat($user_id, $hraid, $data, $table){
        if(($data=='')||($user_id=='')||($hraid=='')) return false;
        $subquery = '';
        foreach($data as $key => $value){
            $subquery .= '`'.$key.'` = "'.$value.'",';
        }
        $subquery = substr($subquery, 0, -1);
        $query = 'UPDATE '  . $table. ' SET  '. $subquery .' WHERE shn_user_id = '.$user_id .' AND hra_id ='.$hraid;
        $result = update_data($query);
        return $result;
    }

    protected function getStat($user_id='', $orderby='', $table){
        $subquery = ($user_id=='') ? '' : ' WHERE shn_user_id = ' .$user_id ;
        $orderby = ($orderby=='') ? '' : ' ORDER BY ' .$orderby ;
        $query = 'SELECT *  FROM '  . $table.$subquery.$orderby;
        $result = get_data($query);
        return $result;
    }




    protected function updateHra($user_id, $hraid, $data, $table){
        if(($data=='')||($user_id=='')||($hraid=='')) return false;
        $subquery = '';
        foreach($data as $key => $value){
            $subquery .= '`'.$key.'` = "'.$value.'",';
        }
        $subquery = substr($subquery, 0, -1);
        $query = 'UPDATE '  . $table. ' SET  '. $subquery .' WHERE shn_user_id = '.$user_id .' AND shn_hra_id ='.$hraid;
        $result = update_data($query);
        return $result;
    }

    protected function updateQuestion($qid, $main, $data, $table){
        if(($data=='')||($qid=='')||($main=='')) return false;
        $subquery = '';
        foreach($data as $key => $value){
            $subquery .= '`'.$key.'` = "'.$value.'",';
        }
        $subquery = substr($subquery, 0, -1);
        $query = 'UPDATE '  . $table. ' SET  '. $subquery .' WHERE h2_question_id = '.$qid. ' AND main = '.$main ;
        $result = update_data($query);
        return $result;
    }
    protected function updateAnswer($aid, $data, $table){
        if(($data=='')||($aid=='')) return false;
        $subquery = '';
        foreach($data as $key => $value){
            $subquery .= '`'.$key.'` = "'.$value.'",';
        }
        $subquery = substr($subquery, 0, -1);
        $query = 'UPDATE '  . $table. ' SET  '. $subquery .' WHERE h2_answer_id = '.$aid ;
        $result = update_data($query);
        return $result;
    }

    protected function updateDietplan($data, $table){
        if(($data=='')||($data['h2_id']=='')) return false;
        $subquery = '';
        foreach($data as $key => $value){
            if($key=='h2_id'){
                $h2_id = $value;
            }else{
                $subquery .= '`'.$key.'` = "'.$value.'",';
            }
        }
        $subquery = substr($subquery, 0, -1);
        $query = 'UPDATE '  . $table. ' SET  '. $subquery .' WHERE h2_id = '.$h2_id;
        $result = update_data($query);
        return $result;
    }
}