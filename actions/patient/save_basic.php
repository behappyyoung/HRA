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
$h2_hra_id = $_POST["h2_hra_id"];
$age = $_POST["age"];
$gender = $_POST["gender"];
$ethnicity = $_POST["ethnicity"];
$weight = $_POST["weight"];
$waist = $_POST["waist"];
$feet = $_POST["feet"];
$inches = $_POST['inches'];
$livingarea = $_POST["livingarea"];
$error ='';
$paraArray =array();


if(empty($age)){
    $error .= ' age is missing <br /> ';
}


if(empty($livingarea)){
    $error .= ' livting area is missing  <br /> ';
}


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
        'h2_hra_id'=>$h2_hra_id,
        'gender'=>$gender,
        'race'=>$race,
        'weight'=>$weight,
        'waist'=>$waist,
        'age'=>$age,
        'feet'=>$feet,
        'inches'=>$inches,
        'livingarea'=>$livingarea,
        );

    $para = '';
    foreach($paraArray as $key => $value){
        $para .= '&'.$key.'='.$value;
    }

    $forwardURL = $_SERVER['HTTP_REFERER']. $error.$para;

}else{
    $paraArray = array(
        'age'=>$age,
        'gender'=>$gender,
        'ethnicity'=>$ethnicity,
        'weight'=>$weight,
        'height'=>$height
    );


    H2hra::updateBasicInfo($guid, $paraArray);
    $genderuuid = ($gender=='male')? '52134584-5c74-4034-94d5-24bcac116443' : '52134584-c1bc-40a6-9dd8-24bcac116443';
    if($livingarea=='city'){
        $livinguuid = '52120fd4-a0dc-4da7-9b54-2488ac116443';
    }elseif($livingarea=='mountain'){
        $livinguuid = '52120fd4-aabc-4fa0-afb0-2488ac116443';
    }elseif($livingarea=='suburbs'){
        $livinguuid = '52120fd4-8d8c-4aec-b954-2488ac116443';
    }
    $answerArray = array(
                        'hra_id'=>$h2_hra_id,
                        "answers[gender]"=>$genderuuid,
                        "answers[ethnicity]"=>$ethnicity,
                        "answers[weight]"=>$weight,
                        "answers[age]"=>$age,
                        "answers[height]"=>$height,
                        "answers[waist]"=>$waist,
                        "answers[living_area]"=>$livinguuid);
    $result = H2hra::postAnswers($token, $answerArray);

    $forwardURL = elgg_get_site_url().'hra/form/1/'.$h2_hra_id;
}

forward($forwardURL);
