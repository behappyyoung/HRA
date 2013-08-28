<?php
$guid = elgg_extract('guid', $vars, '');
$h2_hra_id = elgg_extract('h2_hra_id', $vars, '');
$retake = elgg_extract('retake', $vars, '');
$current_survey = elgg_extract('current_survey', $vars, '');
$current_survey = ($current_survey=='')? '1' : $current_survey;

if($retake=='retake'){
    $myAnswers = H2hra::getAnswers($token,$h2_hra_id);
}


$userinfo = (array) H2hra::getHraUser($guid);
$token = $userinfo['h2_token'];


//  need to update to real API
$surveylist = array(
                    1 => 'Eating & Lifestyle Habits',
                    2 => 'Screening for Healthy Living/ Cancer Preventa',
                    3 => 'Fitness Level Questionnaire',
                    4 => 'Program Goals',
                    5 => 'Screening for Healthy Heart Diet Plan',
                    6 => 'Screening for Diabetic Health Program',
                    7 => 'Screening for Healthy Joint Diet');

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
    .form .number{background-color:#cb842e; padding: 3px;margin-right: 10px;}
    .form-table { width: 95%;border-collapse: separate; border-spacing:0 5px;}
    .form-table tr {margin: 5px;vertical-align: middle; background-color: #d2e3ec;}
    .form-table td {height: 50px; margin: 5px;vertical-align: middle;padding: 10px;}
    .form-table .label {width: 100px;font-weight: bolder;text-align: left; padding-left: 20px; }
    .form-table .input { text-align: left; padding-left: 40px; }
    .form-table .smallinput  {width:100px; height: 20px; margin: 5px; }
    .form-table .checkbox  {width:20px; }
    .subinfo { width: 500px;}
    .progress {float: right;}
    .subtitle {float:left;font-weight: bolder; text-transform:uppercase; }
    .buttons {float:right;margin-right: 50px;}
    .buttons .cancel {background-color: #d0cbce;}
    .buttons .save {background-color: #9295a4;}

    .error {color: red;}


</style>

<form class="form" id="patient-hra-form" title="Patient hra"  method="post"
      action="<?php echo elgg_add_action_tokens_to_url("/action/hra/save_form"); ?>">
    <input type="hidden" name="guid" value="<?=$guid?>" />
    <input type="hidden" name="token" value="<?=$token?>" />
    <input type="hidden" name="h2_hra_id" value="<?=$h2_hra_id?>" />
    <input type="hidden" name="current_survey" value="<?=$current_survey?>" />
    <div class="form-tabs" id="form-tabs"> </div>
    <div class="subinfo">

        <div class="subtitle" > <?=$subtitle?> </div>
        <div class="progress" id="progress">
            <?php
            for($i=1; $i<=$current_survey;$i++){
                echo '<img src="'.elgg_get_site_url().'/mod/hra/views/default/images/progress.png"/>';
            }
            ?>
            <br />
             <?=(int)(($current_survey)/8*100)?> % completed
        </div>
    </div>
    <div id="tabs" class="form">
        <table class="form-table">
            <!-- Gender & Marital Status -->

            <?php
            foreach($cq as $questionid => $questionArray){
                echo '<tr> <td class="label">  <span class="space">  </span> <span class="required-label"> '.$questionArray['h2_desc'].' </span> </td>';
                echo '<td class="input">';
                $name = 'answers('.$questionArray['name'].')';
                if(empty($questionArray['answerArray'])){
                    echo '<input type="text" name="postanswer['.$name.']" />' ;
                }else{
                    foreach($questionArray['answerArray'] as $answerObject){
                        $selected = ($myAnswers[$questionid]==$answerObject->h2_uuid) ? 'checked=checked ' : '';
                        echo  '<input type="radio" name="postanswer['.$name.']" value=" '.$answerObject->h2_uuid.'"'.$selected.' class="checkbox" > '.$answerObject->h2_desc.'<br />';
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

