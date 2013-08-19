<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ypark
 * Date: 8/16/13
 * Time: 4:13 PM
 * To change this template use File | Settings | File Templates.
 */


$user = elgg_get_logged_in_user_entity();


$age = $_POST["age"];
$gender = $_POST["gender"];
$race = $_POST["race"];


$result = empty($gender) || empty($weight) || empty($height) ||    empty($race) ;

if($result){
    echo elgg_echo('hra:form:missingFields');
//    var_dump($user);
    return;
}


echo "OK";

// next..