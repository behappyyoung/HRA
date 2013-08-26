<?php
$debug = ($_SERVER['SERVER_NAME']=='1127.0.0.1')?true: false;
$user_role = roles_get_role();
$role= $user_role->get("title");

echo $role.'<br />';

?>
<style>

    .hra-table { width: 95%;border-collapse: separate; border-spacing:0 5px;}
    .hra-table tr {margin: 5px;vertical-align: middle; background-color: #d2e3ec;}


</style>
<script>
    function showQuestions() {
        $( "#questions" ).dialog();
    }
    function patchQuestions(){
        jQuery.ajax({
            url: '<?=elgg_add_action_tokens_to_url("hra/patch_questions")?>',
            type : "json",
            success : function(data){
                    alert(data);
                }
            }
        )
    }
</script>

<button class="'elgg-submit-button" onclick="showQuestions();">Update HRA Questions </button>  <br />
<button class="'elgg-submit-button" onclick="patchQuestions();">Patch HRA Questions </button>  <br />
<br />
HRA Status <br />
<table class="hra-table">
    <th>Name</th><th>HRA</th><th>date</th><th>bmi</th><th>bmr</th><th>diet plan</th><th>calories goal</th><th>strength level</th><th>fitness level</th>
    <?php
    foreach($hrainfo as $stat){
        echo '<tr><td>'.$stat->first_name.'</td><td>'.$stat->hra_id.'</td> <td>'.$stat->date.'</td>';
        echo '<td>'.$stat->bmi.'</td><td>'.$stat->bmr.'</td><td>'.$stat->diet_plan.'</td><td>'.$stat->calories_goal.'</td><td>'.$stat->strenth_level.'</td><td>'.$stat->fitness_classification_level.'</td>';

        echo '  <td>';
        echo '</td></tr>';
    }
    ?>
</table>



<div id="questions" title="Basic dialog" style="display:none;">
    <p>TEST.</p>
</div>
