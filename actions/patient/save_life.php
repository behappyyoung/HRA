<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ypark
 * Date: 8/16/13
 * Time: 4:13 PM
 * To change this template use File | Settings | File Templates.
 */


$user = elgg_get_logged_in_user_entity();
 var_dump($user);


var_dump($_REQUEST);

$result = empty($gender) || empty($weight) || empty($height) ||    empty($race) ;

if($result){
    echo elgg_echo('hra:form:missingFields');
    return;
}


echo "OK";

// next..