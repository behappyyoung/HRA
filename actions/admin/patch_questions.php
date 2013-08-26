<?php
$debug = ($_SERVER['SERVER_NAME']=='1127.0.0.1')?true: false;
$user_role = roles_get_role();
$role= $user_role->get("title");
$hrainfo = (array) H2hra::getHraStatMember();

//var_dump($hrainfo);
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

$result = 'OK';
echo $result;
exit();
foreach($myquestion as $id => $questionArray){
    if(in_array($id, $qid)){  //exists => update
            echo $id.'update <br />';
    }else{  // insert
        echo $id.'insert <br />';
        try{
            H2hra::saveQuestion($questionArray);
        }catch (Exception $e){
            $result .= 'Error : '. $e->getMessage();
        }


    }
}

foreach($myanswer as $id => $answerArray){
    if(in_array($id, $aid)){  //exists => update
        echo $id.'update <br />';
    }else{  // insert
        echo $id.'insert <br />';
        try{
            H2hra::saveAnswer($answerArray);
        }catch (Exception $e){
            $result .= 'Error : '. $e->getMessage();
        }
    }
}

echo $result;
?>
