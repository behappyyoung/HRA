<style>

    .hra-table { width: 95%;border-collapse: separate; border-spacing:0 5px;}
    .hra-table tr {margin: 5px;vertical-align: middle; background-color: #d2e3ec;}


</style>


<?php


$patientinfo = elgg_extract('patientinfo', $vars, '');

$guid =  $patientinfo['guid'];

//check if user has taken any HRA or has account

$hrauserinfo =(array) H2hra::getHraUser($guid);

if(empty($hrauserinfo)){
    $result = H2hra::createAccount($patientinfo['guid'], $patientinfo['username'], $patientinfo['firstname'],
        $patientinfo['lastname'], $patientinfo['gender'], $patientinfo['email'], '1');
    if($result=='OK'){
        forward(elgg_get_site_url().'hra/');
    }else{
        echo $result;
    }

}elseif($hrauserinfo['h2_token']==''){
    $token = H2hra::getSession($hrauserinfo['h2_username'], $hrauserinfo['h2_password']);
    $result= H2hra::saveToken($guid, $token);
    if($result){
        forward(elgg_get_site_url().'hra/');
    }else{
        echo 'DB input Error';
    }

}else{
    echo '<a href="'.elgg_get_site_url().'hra/basic/">Take New Test</a> <br />';
    $hrainfo = (array) H2hra::getH2Stat($guid);
}



?>
<br />
HRA STATS <br />
<table class="hra-table">
    <th>HRA</th><th>date</th><th>bmi</th><th>bmr</th><th>diet plan</th><th>calories goal</th><th>strength level</th><th>fitness level</th>
    <?php
           foreach($hrainfo as $stat){
               echo '<tr><td>'.$stat->shn_hra_id.'</td> <td>'.$stat->date.'</td>';
               echo '<td>'.$stat->bmi.'</td><td>'.$stat->bmr.'</td><td>'.$stat->diet_plan.'</td><td>'.$stat->calories_goal.'</td><td>'.$stat->strenth_level.'</td><td>'.$stat->fitness_classification_level.'</td>';

               echo '  <td>';
               if($stat->done){
                   echo $stat->score;
               }else{
                   echo '<a href="'.elgg_get_site_url().'hra/basic/'.$stat->shn_hra_id.'"> Finish </a>';
               }
               echo '</td></tr>';
           }
    ?>
</table>


