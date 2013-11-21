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

//$questions =  H2hra::getH2Questions($surveylist[$current_survey], 'h2_question_id');
$questions =  H2hra::getH2Questions($current_survey, 'h2_question_id');
//var_dump($questions);
foreach($questions as $question){
    if($question->main==$question->h2_question_id){                         //main
        $subtitle = $question->name;
    }else{                            //sub - real questions
        $answers =  H2hra::getH2Answers($question->h2_question_id);
        $cq[$question->h2_question_id] = array(
                'name' => $question->name,
                'h2_title' => $question->h2_title,
                'h2_desc' => $question->h2_desc,
                'answerArray'=> $answers);
    }
}

?>

<style>


    .form-tabs {background-image: url("<?=elgg_get_site_url()?>/mod/hra/views/default/images/secondactive.png"); height: 40px; width: 600px; font-weight: bolder;}
    .form-table { width: 95%;border-collapse: separate; border-spacing:10px;}
    .form-table .divrow {margin: 5px;vertical-align: middle; background-color: #d2e3ec;}
    .form-table .divcell {height: 50px; margin: 5px;vertical-align: middle;padding: 10px;}
    .form-table .label {width: 500px;font-weight: bolder;text-align: left; padding-left: 20px; padding-top:10px; }
    .form-table .input { text-align: left; padding-left: 40px; padding-bottom:10px; width: 400px;}
    .form-table .smallinput  {width:100px; height: 20px; margin: 5px; font-size:11px;  padding: 1px;}
    .form-table .checkbox  {width:20px; }
    .subinfo { width: 500px;}
    .progress {}
    .subtitle {width:500px;font-weight: bolder; text-transform:uppercase; }

    .buttons {float:right;margin-right: 50px;}
    .buttons .cancel {background-color: #d0cbce;}
    .buttons .save {background-color: #9295a4;}
    .buttons .back {background-color: #9295a4;padding: 4px; 6px;color:black;}

    .error {color: red;}


</style>
<script>

    if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4)))check = true})(navigator.userAgent||navigator.vendor||window.opera){
        // mobile
    }else{
        $( document ).tooltip();
    }

</script>
<form class="form" id="patient-hra-form" method="post"
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
        <div class="form-table">

            <?php
            foreach($cq as $questionid => $questionArray){
                if($questionArray['h2_desc']!=''){
                    $title = str_replace('"', '`', $questionArray['h2_desc']);
                    $titmeimg = '<img src="'.elgg_get_site_url().'/mod/hra/views/default/images/icon_def.png"/>';
                }else{
                    $title = '';
                    $titmeimg='';
                }
                echo '<div class="divrow"> <div class="label">  <span class="space">  </span> <span class="required-label "  title="'.str_replace('"', '`', $questionArray['h2_desc']).'"> '.$questionArray['h2_title'].'  ' .$titmeimg.' </span> </div>';
                echo '<div class="input">';
                $name = 'answers('.$questionArray['name'].')';
                if(empty($questionArray['answerArray'])){
                    echo '<input type="text"  size="10" style="width:auto;" name="postanswer['.$name.']" />' ;
                }else{
                    foreach($questionArray['answerArray'] as $answerObject){
                        $selected = ($myAnswers[$questionid]==$answerObject->h2_uuid) ? 'checked=checked ' : '';
                        echo  '<input type="radio" name="postanswer['.$name.']" value=" '.$answerObject->h2_uuid.'"'.$selected.' class="checkbox" > '.$answerObject->h2_desc.'<br />';
                    }
                }

                echo '</div></div>';
            }
            ?>

        </div>
        <div class="buttons">
            <?php
                if($current_survey>2){
                    --$current_survey;
                    $backUrl = elgg_get_site_url().'hra/form/'.$current_survey.'/'.$h2_hra_id;
                    echo '<a class="back" href="'.$backUrl.'">Back</a>';
                }else{
//                    $backUrl = elgg_get_site_url().'hra/';
                }
            ?>
            <button class="cancel" name="cancel" value="cancel" onclick="<?php  echo 'window.location.href=\''.elgg_get_site_url().'hra/\'';?>">Cancel</button>

            <button  class="save" > Save & Continue </button>
        </div>
    </div>
</form>

