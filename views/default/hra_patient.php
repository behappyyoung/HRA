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
    echo H2hra::createAccount($patientinfo['guid'], $patientinfo['username'], $patientinfo['firstname'],
        $patientinfo['lastname'], $patientinfo['gender'], $patientinfo['email']);
}elseif($hrauserinfo['token']==''){
    $token = H2hra::getSession($hrauserinfo['username'], $hrauserinfo['password']);
    echo H2hra::saveToken($guid, $token);
}else{
    echo '<a href="'.elgg_get_site_url().'hra/basic/">Take New Test</a> <br />';
    $hrainfo = (array) H2hra::getHraStat($guid);
    //var_dump($hrainfo);
}



?>
<br />
HRA STATS <br />
<table class="hra-table">
    <th>HRA</th><th>date</th><th>rescore</th>
    <?php
           foreach($hrainfo as $stat){
               echo '<tr><td>'.$stat->hra_id.'</td> <td>'.$stat->date.'</td>  <td>';
               if($stat->done){
                   echo $stat->score;
               }else{
                   echo '<a href="'.elgg_get_site_url().'hra/basic/'.$stat->hra_id.'"> Continue </a>';
               }
               echo '</td></tr>';
           }
    ?>
</table>


