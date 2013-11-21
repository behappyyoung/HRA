<?php
$guid = elgg_extract('guid', $vars, '');
$hra_id = elgg_extract('hra_id', $vars, '');

$userinfo = (array) H2hra::getHraUser($guid);
$token = $userinfo['token'];

$myAnswers = H2hra::getAnswers($token,$hra_id);

//  need to update to real API


$questions =  H2hra::getBasicQuestions('lifestyle', 'qid');


foreach($questions as $question){
    if($question->type==0){                         //main
        $subtitle = $question->name;
    }elseif($question->type ==1){                            //sub - real questions
        $answers =  H2hra::getBasicAnswers($question->qid);
        $cq[$question->qid] = array('name' => $question->name,
                                    'desc' => $question->desc,
                                     'answerArray'=> $answers);

    }
}

//

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

    .buttons {float:right;margin-right: 50px;}
    .buttons .cancel {background-color: #d0cbce;}
    .buttons .save {background-color: #9295a4;}

    .error {color: red;}


</style>

<form class="form" id="patient-hra-form" title="Patient hra"  method="post"
      action="<?php echo elgg_add_action_tokens_to_url("/action/hra/save_life"); ?>">
    <input type="hidden" name="guid" value="<?=$guid?>" />
    <input type="hidden" name="token" value="<?=$token?>" />
    <input type="hidden" name="hra_id" value="<?=$hra_id?>" />
    <div class="form-tabs" id="form-tabs"> </div>
    <div class="subtitle" > <?=$subtitle?> </div>
         <div id="tabs-basic" class="basic-form">
              <div class="basic-form-table">
                <!-- Gender & Marital Status -->

                  <?php
                    foreach($cq as $questionid => $questionArray){
                        echo '<div> <div class="label">  <span class="space">  </span> <span class="required-label"> '.$questionArray['desc'].' </span> </div>';
                        echo '<div class="input">';
                      //  var_dump($questionArray['answerArray'] );
                        if(empty($questionArray['answerArray'])){
                            echo '<input type="text" name="answers['.$questionArray['name'].']" />' ;
                        }else{
                            foreach($questionArray['answerArray'] as $answerObject){
                                $selected = ($myAnswers[$questionid]==$answerObject->uuid) ? 'checked=checked ' : '';
                                echo  '<input type="radio" name="answers['.$questionArray['name'].']" value=" '.$answerObject->uuid.'"'.$selected.' class="checkbox" > '.$answerObject->desc.'<br />';
                            }
                        }

                        echo '</div></div>';
                    }
                  ?>

            </table>
                <div class="buttons">
                    <a href="<?=elgg_get_site_url()?>hra/"> Cancel </a>
                    <button  class="save" > Save & Continue </button>
                </div>
            </div>
    </form>

