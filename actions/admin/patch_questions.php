<?php

$debug = ($_SERVER['SERVER_NAME']=='1127.0.0.1')?true: false;
$user_role = roles_get_role();
$role= $user_role->get("title");

echo $role;

$token = H2hra::getAdminSession();
$questions =  H2hra::getQuestions($token);

foreach($questions as $sections){

        $QuestionnaireSection = $sections['QuestionnaireSection'];
        $Questionnaire = $sections['Questionnaire'];

        $myquestion[$QuestionnaireSection['id']] = array(
            'h2_question_id'=>$QuestionnaireSection['id'],
            'category' => $QuestionnaireSection['name'],
            'name' =>    $QuestionnaireSection['name'],
            'h2_desc' =>    $QuestionnaireSection['name'],
            'h2_type' => '0',
            'main' => $QuestionnaireSection['id']
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
                'h2_question_id'=>$question['id'],
                'category' => $QuestionnaireSection['name'],
                'name' =>    $question['slug'],
                'h2_desc' =>    $question['title'],
                'h2_type' => $type,
                'main' => $QuestionnaireSection['id']
            );

            $answers = $question['QuestionnaireAnswer'];
            if(!empty($answers)){
                foreach($answers as $answer){

                    $myanswer[$answer['id']] = array(
                        'h2_answer_id'=> $answer['id'],
                        'h2_uuid'=> $answer['uuid'],
                        'shn_hra_question_id'=> $answer['questionnair_id'],
                        'h2_desc'=> $answer['answer'],
                  //      'score'=> $answer['score'],
                        'h2_type'=>'select'            // all select for now
                    );
                }

            }
        }

}


//$localquestions = H2hra::getLocalQuestions();
$qid = H2hra::getLocalQuestionIDs();
$aid = H2hra::getLocalAnswerIDs();

$result = 'OK';
foreach($myquestion as $id => $questionArray){
    if(in_array($id, $qid)){  //exists => update
        try{
            H2hra::updateH2Question($id, $questionArray);
        }catch (Exception $e){
            $result .= 'Error : '. $e->getMessage();
        }
    }else{  // insert
        try{
            H2hra::saveQuestion($questionArray);
        }catch (Exception $e){
            $result .= 'Error : '. $e->getMessage();
        }


    }
}

foreach($myanswer as $id => $answerArray){
    if(in_array($id, $aid)){  //exists => update
        try{
            H2hra::updateH2Answer($id, $answerArray);
        }catch (Exception $e){
            $result .= 'Error : '. $e->getMessage();
        }
    }else{  // insert
        try{
            H2hra::saveAnswer($answerArray);
        }catch (Exception $e){
            $result .= 'Error : '. $e->getMessage();
        }
    }
}

echo $result;
exit();
?>
