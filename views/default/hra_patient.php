<style>

    .hra-table { width: 95%;border-collapse: separate; border-spacing:0 5px;}
    .hra-table tr {margin: 5px;vertical-align: middle; background-color: #d2e3ec;}


</style>

<a href="<?=elgg_get_site_url()?>hra/basic/">Take New Test</a> <br />
<?php

$user = elgg_get_logged_in_user_entity();
//var_dump($GLOBALS);
var_dump($user);
$username= $user->get('username');
$name= explode(' ', $user->get('name'));
$guid =  $user->getGUID();

echo  H2hra::createAccount($guid, $username, $name[0], $name[1]);

$patientsMetadata = elgg_get_metadata(array(
    "metadata_names" =>  array("gender"),
    'metadata_owner_guids' =>  array("63")
));

var_dump($patientsMetadata);

foreach($patientsMetadata as $currentMetadata){
        $meta_export= $currentMetadata->export();

    var_dump($meta_export);


    $value = $meta_export->getBody();

    echo $value;

}
?>

HRA History <br />
<table class="hra-table">
    <th>HRA</th><th>date</th><th>score</th>
    <tr>
        <td>fdsfas</td>
        <td>08-19-2013</td>
        <td>20</td>
    </tr>
</table>


