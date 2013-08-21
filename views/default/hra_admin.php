<style>

    .hra-table { width: 95%;border-collapse: separate; border-spacing:0 5px;}
    .hra-table tr {margin: 5px;vertical-align: middle; background-color: #d2e3ec;}


</style>

<?php



?>
<br />
HRA Status <br />
<table class="hra-table">
    <th> member name </th><th>HRA</th><th>date</th><th>score</th>
    <?php
    $hrainfo = (array) H2hra::getHraStat($guid);

    foreach($hrainfo as $stat){
        echo '<tr><td>'.$guid.'</td>';

        echo '<td>'.$stat->hra_id.'</td> <td>'.$stat->date.'</td>  <td>';
        if($stat->done){
            echo $stat->score;
        }else{
            echo '--';
        }
        echo '</td></tr>';
    }
    ?>
</table>


