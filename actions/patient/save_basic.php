<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ypark
 * Date: 8/16/13
 * Time: 4:13 PM
 * To change this template use File | Settings | File Templates.
 */


$user = elgg_get_logged_in_user_entity();

$guid = $_POST["guid"];
$token = $_POST["token"];
$hra_id = $_POST["hra_id"];
//$age = $_POST["age"];
$gender = $_POST["gender"];
$ethnicity = $_POST["ethnicity"];
$weight = $_POST["weight"];
//$waist = $_POST["waist"];
$feet = $_POST["feet"];
$inches = $_POST['inches'];
//$livingarea = $_POST["livingarea"];
$error ='';
$paraArray =array();



if(empty($gender)){
    $error .= ' gender is missing  <br /> ';
}

if(empty($ethnicity)){
    $error .= ' ethnicity is missing  <br />';
}

if(empty($weight)){
    $error .= ' weight is missing  <br /> ';
}




if(empty($feet)||empty($inches)){
    $error .= ' height is missing  <br />';
}else{
    $height = $feet.'.'.$inches;
}


if($error!=''){
    $error = '?retry=true&error='.$error;
    $paraArray = array(
        'guid'=>$guid,
        'token'=>$token,
        'hra_id'=>$hra_id,
        'gender'=>$gender,
        'race'=>$race,
        'weight'=>$weight,

        'feet'=>$feet,
        'inches'=>$inches,

        );

    $para = '';
    foreach($paraArray as $key => $value){
        $para .= '&'.$key.'='.$value;
    }

    $forwardURL = $_SERVER['HTTP_REFERER']. $error.$para;

}else{
    $paraArray = array(

        'gender'=>$gender,
        'ethnicity'=>$ethnicity,
        'weight'=>$weight,

        'height'=>$height
    );


    H2hra::updateBasicInfo($guid, $paraArray);
    $genderuuid = ($gender=='male')? '52134584-5c74-4034-94d5-24bcac116443' : '52134584-c1bc-40a6-9dd8-24bcac116443';

    $answerArray = array(
                        'hra_id'=>$hra_id,
                        "answers[gender]"=>$genderuuid,
        "answers[ethnicity]"=>$ethnicity,
        "answers[weight]"=>$weight,

        "answers[height]"=>$height
                    );
    $result = H2hra::postAnswers($token, $answerArray);

   // $forwardURL = elgg_get_site_url().'hra/life/'.$hra_id;
    $forwardURL = elgg_get_site_url().'hra/form/1/'.$hra_id;
}

forward($forwardURL);
