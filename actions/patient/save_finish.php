<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ypark
 * Date: 8/16/13
 * Time: 4:13 PM
 * To change this template use File | Settings | File Templates.
 */

var_dump($_REQUEST);
$token = $_POST["token"];
$hra_id = $_POST["hra_id"];


$answerPost = $_POST["answers"];
$answerArray = array('hra_id'=>$hra_id);
foreach($answerPost as $key => $value){
    if($value!=''){
        $answerArray['answers['.$key.']'] = $value;
    }

}

$result = H2hra::postAnswers($token, $answerArray);

$forwardURL = elgg_get_site_url().'hra/life/'.$hra_id;

exit();
    $forwardURL = elgg_get_site_url().'/hra/finish';

forward($forwardURL);
