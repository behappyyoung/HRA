<?php
$debug = ($_SERVER['SERVER_NAME']=='1127.0.0.1')?true: false;
$user_role = roles_get_role();
$role= $user_role->get("title");
$hrainfo = (array) H2hra::getHraStatMember();

var_dump($hrainfo);
$token = H2hra::getAdminSession();

$questions =  H2hra::getQuestions($token);

foreach($questions as $sections){

        $QuestionnaireSection = $sections['QuestionnaireSection'];
        $Questionnaire = $sections['Questionnaire'];

        $myquestion[$QuestionnaireSection['id']] = array(
            'qid'=>$QuestionnaireSection['id'],
            'category' => $QuestionnaireSection['name'],
            'name' =>    $QuestionnaireSection['name'],
            'desc' =>    $QuestionnaireSection['name'],
            'type' => '0',
            'main' => '0'
        );
        foreach($Questionnaire as $question){
            switch($question->gender){
                case 'both' : $type = 0;
                    break;
                case 'male' : $type = 1;
                    break;
                case 'female' : $type = 2;
                    break;
            }
            $myquestion[$question['id']] = array(
                'qid'=>$question['id'],
                'category' => $QuestionnaireSection['name'],
                'name' =>    $question['slug'],
                'desc' =>    $question['title'],
                'type' => $type,
                'main' => $QuestionnaireSection['id']
            );

            $answers = $question['QuestionnaireAnswer'];
            if(!empty($answers)){
                foreach($answers as $answer){

                    $myanswer[$answer['id']] = array(
                        'aid'=> $answer['id'],
                        'uuid'=> $answer['uuid'],
                        'qid'=> $answer['questionnair_id'],
                        'desc'=> $answer['answer'],
                        'score'=> $answer['score'],
                        'type'=>'select'            // all select for now
                    );
                }

            }
        }

}

//var_dump($myquestion);
//var_dump($myanswer);

//$localquestions = H2hra::getLocalQuestions();
$qid = H2hra::getLocalQuestionIDs();
$aid = H2hra::getLocalAnswerIDs();

var_dump($qid);

foreach($myquestion as $id => $questionArray){
    if(in_array($id, $qid)){  //exists => update
            echo $id.'update <br />';
    }else{  // insert
        echo $id.'insert <br />';
      //  H2hra::saveQuestion($questionArray);
    }
}

foreach($myanswer as $id => $answerArray){
    if(in_array($id, $aid)){  //exists => update
        echo $id.'update <br />';
    }else{  // insert
        echo $id.'insert <br />';
        H2hra::saveAnswer($answerArray);
    }
}


?>
<style>

    .hra-table { width: 95%;border-collapse: separate; border-spacing:0 5px;}
    .hra-table tr {margin: 5px;vertical-align: middle; background-color: #d2e3ec;}


</style>
<script>
    function showQuestions() {
        $( "#questions" ).dialog();
    }
</script>

<button class="'elgg-submit-button" onclick="showQuestions();">HRA Questions </button>  <br />
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
    <p>This is the default dialog which is useful for displaying information. The dialog window can be moved, resized and closed with the 'x' icon.</p>
</div>
