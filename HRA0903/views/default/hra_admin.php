<?php
$debug = ($_SERVER['SERVER_NAME']=='1127.0.0.1')?true: false;
$user_role = roles_get_role();
$role= $user_role->get("title");
$hrainfo = (array) H2hra::getHraStatMembers();
 //if($_SERVER['SERVER_NAME']=='127.0.0.1') var_dump($hrainfo);
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
            url: '<?=elgg_add_action_tokens_to_url("action/hra/patch_questions")?>',
            type : "json",
            success : function(data){
                    alert(data);
                }
            }
        )
    }
</script>

<style type="text/css">
    div.clearHRA {
        clear: both;
    }
    button.retake_hra {
        border:1px solid #A72B0B;
        color:#fff;
        background:url(/mod/hra/images/retake.png) no-repeat 5px center #CC3E17;
        padding:5px 10px 5px 25px;
        float:right;
        margin:20px;
    }
    /*.col1 {width:20%;}
    .col2 {width:10%;}
    .col3 {width:10%;}
    .col4 {width:45%;}*/
    .hra_column {
        display:inline-block;
        float:left;
        height:auto;
        padding:5px;
        vertical-align:bottom;
        width: 9%;
    }
    .hra_row { padding:10px; border-bottom:1px solid #CCC;}
</style>

<button class="'elgg-submit-button" onclick="showQuestions();">Update HRA Questions </button>  <br />
<button class="'elgg-submit-button" onclick="patchQuestions();">Patch HRA Questions </button>  <br />
<br />
HRA Status <br />

<div id="hraWrapper">
    <div class="clearHRA"></div>
    <div class="hra_row">
        <div class="hra_column">Name</div>
        <div class="hra_column">ID</div>
        <div class="hra_column">Date</div>
        <div class="hra_column">BMI</div>
        <div class="hra_column">BMR</div>
        <div class="hra_column">Diet></div>
        <div class="hra_column">C. Goal</div>
        <div class="hra_column">S. Level</div>
        <div class="hra_column">F. Class.</div>
        <div class="hra_column">&nbsp;</div>
        <div class="clearHRA"></div>
    </div>
    <?php
    foreach($hrainfo as $stat) {
    ?>
    <div class="hra_row">
        <div class="hra_column"><?php echo($stat->first_name); ?></div>
        <div class="hra_column"><?php echo($stat->hra_id); ?></div>
        <div class="hra_column"><?php echo($stat->date); ?></div>
        <div class="hra_column"><?php echo($stat->bmi); ?></div>
        <div class="hra_column"><?php echo($stat->bmr); ?></div>
        <div class="hra_column"><?php echo($stat->diet_plan); ?></div>
        <div class="hra_column"><?php echo($stat->calories_goal); ?></div>
        <div class="hra_column"><?php echo($stat->strenth_level); ?></div>
        <div class="hra_column"><?php echo($stat->fitness_classification_level); ?></div>
        <div class="hra_column">&nbsp;</div>
        <div class="clearHRA"></div>
    <?php } ?>
    </div>
</div>

<div id="questions" title="Basic dialog" style="display:none;">
    <p>TEST.  NOT YET</p>
</div>
