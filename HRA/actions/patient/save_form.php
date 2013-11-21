<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ypark
 * Date: 8/16/13
 * Time: 4:13 PM
 * To change this template use File | Settings | File Templates.
 */

$token = $_POST["token"];
$h2_hra_id = $_POST["h2_hra_id"];
$current_survey = $_POST['current_survey'];


$answerArray = array('hra_id'=>$h2_hra_id);
if(isset($_POST["postanswer"])){
    $answerPost = $_POST["postanswer"];
    foreach($answerPost as $key => $value){
        if($value!=''){
            $key=str_replace('(', '[', $key);
            $key=str_replace(')', ']', $key);
            $answerArray[$key] = $value;
        }
     }
    $result = H2hra::postAnswers($token, $answerArray);
}



if($current_survey=='7'){
    $forwardURL = elgg_get_site_url().'hra/finish/'.$h2_hra_id;
}else{
    $current_survey++;
    $forwardURL = elgg_get_site_url().'hra/form/'.$current_survey.'/'.$h2_hra_id;
}


forward($forwardURL);
