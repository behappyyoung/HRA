<?php
$guid = elgg_extract('guid', $vars, '');
$hra_id = elgg_extract('hra_id', $vars, '');
$current_survey = elgg_extract('current_survey', $vars, '');
$current_survey = ($current_survey=='')? '1' : $current_survey;


if($_SERVER['SERVER_NAME']=='127.0.0.1') var_dump($_REQUEST);

$userinfo = (array) H2hra::getHraUser($guid);
$token = $userinfo['h2_token'];


//  need to update to real API
$surveylist = array(
                    1 => 'Basic Profile',
                    2 => 'Eating & Lifestyle Habits',
                    3 => 'Screening for Healthy Living/ Cancer Preventa',
                    4 => 'Fitness Level Questionnaire',
                    5 => 'Program Goals',
                    6 => 'Screening for Healthy Heart Diet Plan',
                    7 => 'Screening for Diabetic Health Program',
                    8 => 'Screening for Healthy Joint Diet');

$questions =  H2hra::getH2Questions($surveylist[$current_survey], 'h2_question_id');

foreach($questions as $question){
    if($question->main==$question->h2_question_id){                         //main
        $subtitle = $question->name;
    }else{                            //sub - real questions
        $answers =  H2hra::getH2Answers($question->h2_question_id);
        $cq[$question->h2_question_id] = array(
                'name' => $question->name,
                'h2_desc' => $question->h2_desc,
                'answerArray'=> $answers);
    }
}

?>

<style>

    .form-tabs {background-image: url("<?=elgg_get_site_url()?>/mod/hra/views/default/images/secondactive.png"); height: 40px; width: 600px; font-weight: bolder;}
    .basic-form .number{background-color:#cb842e; padding: 3px;margin-right: 10px;}
    .basic-form-table { width: 95%;border-collapse: separate; border-spacing:0 5px;}
    .basic-form-table tr {margin: 5px;vertical-align: middle; background-color: #d2e3ec;}
    .basic-form-table td {height: 50px; margin: 5px;vertical-align: middle;padding: 10px;}
    .basic-form-table .label {width: 100px;font-weight: bolder;text-align: left; padding-left: 20px; }
    .basic-form-table .input { text-align: left; padding-left: 40px; }
    .basic-form-table .smallinput  {width:100px; height: 20px; margin: 5px; }
    .basic-form-table .checkbox  {width:20px; }
    .subtitle {font-weight: bolder; text-transform:uppercase; }
    .buttons {float:right;margin-right: 50px;}
    .buttons .cancel {background-color: #d0cbce;}
    .buttons .save {background-color: #9295a4;}

    .error {color: red;}


</style>

<form class="form" id="patient-hra-form" title="Patient hra"  method="post"
      action="<?php echo elgg_add_action_tokens_to_url("/action/hra/save_form"); ?>">
    <input type="hidden" name="guid" value="<?=$guid?>" />
    <input type="hidden" name="token" value="<?=$token?>" />
    <input type="hidden" name="hra_id" value="<?=$hra_id?>" />
    <input type="hidden" name="current_survey" value="<?=$current_survey?>" />
    <div class="form-tabs" id="form-tabs"> </div>
    <div class="progress" id="progress">  <img /> </div>
    <div class="subtitle" > <?=$subtitle?> </div>
    <div id="tabs-basic" class="basic-form">
        <table class="basic-form-table">
            <!-- Gender & Marital Status -->

            <?php
            foreach($cq as $questionid => $questionArray){
                echo '<tr> <td class="label">  <span class="space">  </span> <span class="required-label"> '.$questionArray['h2_desc'].' </span> </td>';
                echo '<td class="input">';
                if(empty($questionArray['answerArray'])){
                    echo '<input type="text" name="answers['.$questionArray['name'].']" />' ;
                }else{
                    foreach($questionArray['answerArray'] as $answerObject){
                        $selected = ($myAnswers[$questionid]==$answerObject->h2_uuid) ? 'checked=checked ' : '';
                        echo  '<input type="radio" name="answers['.$questionArray['name'].']" value=" '.$answerObject->h2_uuid.'"'.$selected.' class="checkbox" > '.$answerObject->h2_desc.'<br />';
                    }
                }

                echo '</td></tr>';
            }
            ?>

        </table>
        <div class="buttons">
            <a href="<?=elgg_get_site_url()?>hra/"> Cancel </a>
            <button  class="save" > Save & Continue </button>
        </div>
    </div>
</form>

