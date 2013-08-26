<?php

$guid = elgg_extract('guid', $vars, '');
$hra_id = elgg_extract('hra_id', $vars, '');

$userinfo = (array) H2hra::getHraUser($guid);
$token = $userinfo['token'];


$myResult = H2hra::getResult($token,$hra_id);

$myAnswers = H2hra::getAnswers($token,$hra_id);

if($_SERVER['SERVER_NAME']=='1127.0.0.1') var_dump($myAnswers);
$serialAnswers = serialize($myAnswers);

//save result
$para = $myResult;
$para['answerlists'] = str_replace('"', '\'', $serialAnswers);
$result = H2hra::updateResult($guid, $hra_id, $para);


?>

<style>

    .form-tabs {background-image: url("<?=elgg_get_site_url()?>/mod/hra/views/default/images/thirdactive.png"); height: 40px; width: 600px; font-weight: bolder;}
    .basic-form .number{background-color:#cb842e; padding: 3px;margin-right: 10px;}
    .basic-form-table { width: 95%;border-collapse: separate; border-spacing:0 5px;}
    .basic-form-table tr {margin: 5px;vertical-align: middle; background-color: #d2e3ec;}
    .basic-form-table td {height: 50px; margin: 5px;vertical-align: middle;padding: 10px;}
    .basic-form-table .label {width: 100px;font-weight: bolder;text-align: left; padding-left: 20px; }
    .basic-form-table .input { text-align: left; padding-left: 40px; }
    .basic-form-table .smallinput  {width:100px; height: 20px; margin: 5px; }
    .basic-form-table .checkbox  {width:20px; }

    .buttons {float:right;margin-right: 50px;}
    .buttons .cancel {background-color: #d0cbce;}
    .buttons .save {background-color: #9295a4;}

    .error {color: red;}


</style>

    <div class="form-tabs" id="form-tabs"> </div>
    <div class="subtitle" > <?=$subtitle?> </div>
         <div id="tabs-basic" class="basic-form">
              <table class="basic-form-table">
                <!-- Gender & Marital Status -->
                    <th colspan="2"> Your Result </th>
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

