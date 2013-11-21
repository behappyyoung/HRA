<?php
require_once( elgg_get_plugins_path(). "nutrition/classes/H2Nutrition.php");

$user = elgg_get_page_owner_entity();
$guid =  $user->getGUID();
$user_id = H2hra::getUserId($guid);
if($user_id){
$hrainfo = (array) H2hra::getMostRecentHraStat($user_id);

if(!empty($hrainfo)){
    foreach($hrainfo as $stat){
        echo '<b>BMI</b>: '. $stat->bmi. '<br />';
        echo '<b>BMR</b> : '. $stat->bmr. '<br />';
        echo '<b>Diet Plan</b>: '. $stat->diet_plan. '<br />';
        echo '<b>Strength Level</b>: '. $stat->strength_level. '<br />';
        echo '<b>Aerobic Capacity</b>: '. $stat->aerobic_capacity. '<br />';
    }
}else{
    echo 'No HRA History';
}
}else{
    echo 'No HRA History';
}


?>
