<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ypark
 * Date: 8/16/13
 * Time: 4:13 PM
 * To change this template use File | Settings | File Templates.
 */

if($_SERVER['SERVER_NAME']=='1127.0.0.1') var_dump($_REQUEST);
$token = $_POST["token"];
$hra_id = $_POST["hra_id"];
$current_survey = $_POST['current_survey'];

$answerPost = $_POST["answers"];
$answerArray = array('hra_id'=>$hra_id);
foreach($answerPost as $key => $value){
    if($value!=''){
        $answerArray['answers['.$key.']'] = $value;
    }

}

$result = H2hra::postAnswers($token, $answerArray);

if($current_survey=='7'){
    $forwardURL = elgg_get_site_url().'hra/finish/'.$hra_id;
}else{
    $current_survey++;
    $forwardURL = elgg_get_site_url().'hra/form/'.$current_survey.'/'.$hra_id;
}


forward($forwardURL);
