<?php
/**
 * Created by JetBrains PhpStorm.
 * User: young
 * Date: 9/16/13
 * Time: 3:13 PM
 * To change this template use File | Settings | File Templates.
 */

$guid = $_REQUEST['guid'];
$fid = $_REQUEST['fid'];
$when = $_REQUEST['when'];
$fname = $_REQUEST['fname'];
$fcal = $_REQUEST['fcal'];
$fpro = $_REQUEST['fpro'];
$ffat = $_REQUEST['ffat'];
$ffib = $_REQUEST['ffib'];
$fcarb = $_REQUEST['fcarb'];
$funit = $_REQUEST['funit'];
$amount = $_REQUEST['amount'];



if(empty($fid)){
    // user input

}else{
    // get food from H2
    $foodArray = array (
        'name' => $fname,
        'h2_id' => $fid,
        'h2_name' => $fname,
        'Cal' => $fcal,
        'Pro' => $fpro,
        'Fat'=> $ffat,
        'Carb'=> $fcarb,
        'Fib' => $ffib
    );
    $food_id = H2Nutrition::addH2Food($foodArray);
    $user_id = H2Nutrition::getUserId($guid);
    $logArray = array(
        'shn_user_id' => $user_id,
        'shn_nutrition_food_id' => $food_id,
        'unit' => $funit,
        'date' => date('Y-m-d'),
        'type'  => $when,
        'amount' => $amount
    );
    $result = H2Nutrition::updateFoodlog($logArray);


echo $result;

}

exit();
?>