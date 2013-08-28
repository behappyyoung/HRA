<?php

$guid = elgg_extract('guid', $vars, '');
$h2_hra_id = elgg_extract('h2_hra_id', $vars, '');

$userinfo = (array) H2hra::getHraUser($guid);
$token = $userinfo['h2_token'];


$myResult = H2hra::getResult($token,$h2_hra_id);

$myAnswers = H2hra::getAnswers($token,$h2_hra_id);
//if($_SERVER['SERVER_NAME']=='127.0.0.1') var_dump($myResult);
//if($_SERVER['SERVER_NAME']=='127.0.0.1') var_dump($myAnswers);
$serialAnswers = serialize($myAnswers);

//save result
$dbpara = array(
    'bmi' =>$myResult['bmi'],
    'bmr' =>$myResult['bmr'],
    'diet_plan' =>$myResult['diet_plan'],
    'calories_goal' =>$myResult['calories_goal'],
    'strength_level' =>$myResult['strength_level'],
    'fitness_classification_level' =>$myResult['fitness_classification_level'],
    'vo2_max' =>$myResult['vo2_max'],
    'aerobic_capacity' =>$myResult['aerobic_capacity'],
    'answerlists' =>str_replace('"', '\'', $serialAnswers),
    'done' => '1'
);

$result = H2hra::updateResult($guid, $h2_hra_id, $dbpara);

?>

<style>

    .form-tabs {background-image: url("<?=elgg_get_site_url()?>/mod/hra/views/default/images/thirdactive.png"); height: 40px; width: 600px; font-weight: bolder;}
    .form .number{background-color:#cb842e; padding: 3px;margin-right: 10px;}
    .form-table { width: 95%;border-collapse: separate; border-spacing:0 5px;}
    .form-table tr {margin: 5px;vertical-align: middle; background-color: #d2e3ec;}
    .form-table td {height: 50px; margin: 5px;vertical-align: middle;padding: 10px;}
    .form-table .label {width: 100px;font-weight: bolder;text-align: left; padding-left: 20px; }
    .form-table .input { text-align: left; padding-left: 40px; }
    .form-table .smallinput  {width:100px; height: 20px; margin: 5px; }
    .form-table .checkbox  {width:20px; }
    .subtitle {float:left;font-weight: bolder; text-transform:uppercase; }

    .buttons {float:right;margin-right: 50px;}
    .buttons .cancel {background-color: #d0cbce;}
    .buttons .save {background-color: #9295a4;}

    .error {color: red;}


</style>

    <div class="form-tabs" id="form-tabs"> </div>
    <div class="subtitle" > Your Result </div>
         <div id="tabs-basic" class="form">
              <table class="form-table">
                  <tr><td>  </td> <td> </td></tr>
                  <?php
                    foreach($myResult as $key => $value){
                        echo '<tr> <td class="label">  <span class="space">  </span> <span class="required-label"> '.$key.' </span> </td>';
                        echo '<td class="input"> '.$value.' </td></tr>';
                    }
                  ?>

            </table>
                <div class="buttons">
                    <a href="<?=elgg_get_site_url()?>hra/" > DONE </a>
                </div>
            </div>

