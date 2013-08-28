<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ypark
 * Date: 8/15/13
 * Time: 10:02 AM
 * for h2wellness hra APIs
 */

error_reporting(E_ALL);

$debugmode = ($_SERVER['SERVER_NAME']=='ubuntuone') ? true : false;

define('HRA_BASERUL', 'http://services.h2wellness.com/rest');
define('HRA_CREATE_SESSION', HRA_BASERUL.'/security/create_session/');
define('HRA_CREATE_PATIENT', HRA_BASERUL.'/patients/create/');
define('HRA_CREATE_ASSESSMENT', HRA_BASERUL.'/hra/create/');
define('HRA_GET_QUESTIONS', HRA_BASERUL.'/hra/questions/');
define('HRA_POST_ANSWERS', HRA_BASERUL.'/hra/update/');
define('HRA_RESULT', HRA_BASERUL.'/hra/result/');

define('HRA_INFO_TABLE', 'hra_basicinfo');
define('HRA_STAT_TABLE', 'hra_stat');
define('HRA_QUESTION_TABLE', 'hra_questions');
define('HRA_ANSWER_TABLE', 'hra_answers');


define('HRA_TABLE', 'shn_hras');
define('SHN_USER_TABLE', 'shn_users');
define('STAT_TABLE', 'shn_hra_stats');
define('QUESTION_TABLE', 'shn_hra_questions');
define('ANSWER_TABLE', 'shn_hra_answers');



class H2hra extends HRA{
    public static function getAdminSession(){
        return H2hra::getSession('young', 'young');
    }
    public static function getSession($username, $password){
        $createURL = HRA_CREATE_SESSION;
        $para = array('username'=>$username,
                        'password' => $password);
        $output = HRA::getJsonData($createURL, $para, true);
        $decodedArray = json_decode($output, true);
        $token = $decodedArray['data']['response']['User']['token'];
        return $token;
    }

    public static function getQuestions($token){
        $questionURL = HRA_GET_QUESTIONS.'?token='.$token;
        $ch = curl_init($questionURL);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = substr($output, strpos($output, '{'));
        if($output){
            $decodedArray = json_decode($output, true);

            $responseArray = ($decodedArray['data']['response']);
            return $responseArray;
        }else{
            return false;
        }

    }

    public static function getAssessment($token){
        $assessmentURL = HRA_CREATE_ASSESSMENT.'?token='.$token;
        $output = HRA::getJsonData($assessmentURL, '', true);
        $decodedArray = json_decode($output, true);
        $hraID = ($decodedArray['data']['response']['hra_id']);
        return $hraID;

    }

    public static function postAnswers($token, $para){
        $postURL = HRA_POST_ANSWERS.'?token='.$token;
        $output = HRA::getJsonData($postURL, $para, true);
        $decodedArray = json_decode($output, true);

        return $decodedArray;

    }


    public static function getResult($token, $hraID){
        $resultURL = HRA_RESULT.'?token='.$token;
        $para = array('hra_id'=>$hraID);
        $output = HRA::getJsonData($resultURL, $para, true);
        $decodedArray = json_decode($output, true);
        $responseArray = ($decodedArray['data']['response']['results']);
        if(empty($responseArray)){
             return 'no answer for this hra';
        }else{
            return $responseArray;
        }
    }

    public static function getAnswers($token, $hraID){
        $resultURL = HRA_RESULT.'?token='.$token;
        $para = array('hra_id'=>$hraID);
        $output = HRA::getJsonData($resultURL, $para, true);
        $decodedArray = json_decode($output, true);
        $responseArray = ($decodedArray['data']['response']['answers']);
        if(empty($responseArray)){
            return 'no answer for this hra';
        }else{
            foreach($responseArray as $answers){
                $answerArray[$answers['question_id']] = $answers['score'];
            }
            return $answerArray;
        }
    }

    public static function createAccount($guid, $username, $firstname, $lastname, $gender, $email, $client_id='1'){
        $createURL = HRA_CREATE_PATIENT;
        $password = $username;
        $gender = ($gender=='')? 'M' : $gender;
        $para = array('first_name' =>$firstname,
                        'last_name'=> $lastname,
                        'gender' => $gender,
                        'email' => $email,
                        'client_id' => $client_id,
                        'username'=>$username,
                        'password'=>$password);

        $output = json_decode(HRA::getJsonData($createURL, $para, true), true);

        var_dump( $output);
        //if($output['meta']['status']=='OK'){
        if($output==null){
            $dbpara = array('elgg_user_guid'=>$guid,
                'first_name' =>$firstname,
                'last_name'=> $lastname,
                'gender' => $gender,
                'email' => $email,
                'shn_client_id'=>$client_id,
                'h2_username'=>$username,
                'h2_password'=>$password);

            try{
                $result = HRA::saveInfo($dbpara, SHN_USER_TABLE);  // $result has User ID... need replace guid with user ID later
                $token = H2hra::getSession($username, $password);
                H2hra::saveToken($guid, $token);
                return 'OK';
            }catch (Exception $e) {
                return 'DB Error : '. $e->getMessage();
            }
        }elseif($output['meta']['feedback'][0]['message'][0]=='email already exists'){
            $token = H2hra::getSession($username, $password);
            saveToken($guid, $token);
            return 'OK';
        }else{
            return  $output['meta']['status'].'--'.$output['meta']['feedback'][0]['message'][0];
        }

        //return $guid. $username. $firstname. $lastname.$gender;

    }
    public  static function getUserId($guid){
        $query = 'SELECT id  FROM ' . elgg_get_config("dbprefix") . SHN_USER_TABLE.' WHERE elgg_user_guid ='.$guid;
        $hrauserinfo = get_data($query);
        return $hrauserinfo[0]->id;
    }

    public static function getHraUser($guid){
       $query = 'SELECT *  FROM ' . elgg_get_config("dbprefix") . SHN_USER_TABLE.' WHERE elgg_user_guid ='.$guid;
        $hrauserinfo = get_data($query);
        return $hrauserinfo[0];
    }
/*
    public static function getHraStat($guid='', $orderby=''){
        $subquery = ($guid=='') ? '' : ' WHERE guid = ' .$guid ;
        $orderby = ($orderby=='') ? '' : ' ORDER BY ' .$orderby ;
        $query = 'SELECT *  FROM ' . elgg_get_config("dbprefix") . STAT_TABLE.$subquery.$orderby;
        $hrainfo = get_data($query);
        return $hrainfo;
    }

*/

    public static function getHraStatMember($guids='', $orderby=''){
        $subquery = ($guid=='') ? '' : ' WHERE guid in ( ' .$guids.') ' ;
        $orderby = ($orderby=='') ? '' : ' ORDER BY ' .$orderby ;
        $query = 'SELECT S.*, I.first_name, I.last_name  FROM ' . elgg_get_config("dbprefix") . STAT_TABLE.' S JOIN '
            . elgg_get_config("dbprefix") .HRA_INFO_TABLE.' I ON S.guid = I.guid '.$subquery. $orderby;
        $hrainfo = get_data($query);
        return $hrainfo;
    }

    public static function getH2HraId($guid){
       // $query = 'select h.h2_hra_id from '.SHN_USER_TABLE.' u, '.STAT_TABLE.' s, '.HRA_TABLE.' h WHERE u.id=s.shn_user_id and s.shn_hra_id = h.id and u.elgg_user_guid = '.$guid;
        $user_id = H2hra::getUserId($guid);
        $query = 'select h.h2_hra_id from '.elgg_get_config("dbprefix") . HRA_TABLE.' h WHERE id = (select shn_hra_id from '.elgg_get_config("dbprefix") . STAT_TABLE.' s WHERE shn_user_id= '.$user_id.')';
        $h2_hra_id = get_data($query);
        return $h2_hra_id;
    }



    public static function getH2Stat($guid='', $orderby=''){
        $query = 'SELECT id  FROM ' . elgg_get_config("dbprefix") . SHN_USER_TABLE .' WHERE elgg_user_guid='.$guid;
        $user_id = get_data($query);
        $hrainfo = HRA::getStat($user_id[0]->id, $orderby, STAT_TABLE);
        return $hrainfo;
    }


    public static function getHraStat($user_id='', $orderby=''){
        $subquery = ($user_id=='') ? '' : ' WHERE shn_user_id = ' .$user_id ;
        $orderby = ($orderby=='') ? '' : ' ORDER BY ' .$orderby ;
        $query = 'SELECT *  FROM ' . elgg_get_config("dbprefix") . STAT_TABLE.$subquery.$orderby;
        $hrainfo = get_data($query);
        return $hrainfo;
    }


    public static function getHraStatMembers($user_ids='', $orderby=''){
        $subquery = ($user_ids=='') ? '' : ' WHERE shn_user_id in ( ' .implode(',', $user_ids).') ' ;
        $orderby = ($orderby=='') ? '' : ' ORDER BY ' .$orderby ;
        $query = 'SELECT *  FROM ' . elgg_get_config("dbprefix") . STAT_TABLE.$subquery.$orderby;
        $hrainfo = get_data($query);
        return $hrainfo;
    }


    public static function getLocalQuestions(){
        $query = 'SELECT *  FROM ' . elgg_get_config("dbprefix") . QUESTION_TABLE;
        $result = get_data($query);
            foreach($result as $questions){
                $localquestion[$questions->qid] = array(
                    'category' => $questions->category,
                    'name' => $questions->name,
                    'desc' => $questions->desc,
                    'type' => $questions->type,
                    'main' => $questions->main,
                );
            }

        return $localquestion;
    }

    public static function getLocalQuestionIDs(){
        $query = 'SELECT h2_question_id  FROM ' . elgg_get_config("dbprefix") . QUESTION_TABLE;
        $result = get_data($query);
        if($result){
            foreach($result as $questions){
                $qid[] = $questions->qid;
            }
        }else{
            $qid = array();
        }


        return $qid;
    }

    public static function getLocalAnswerIDs(){
        $query = 'SELECT h2_answer_id  FROM ' . elgg_get_config("dbprefix") . ANSWER_TABLE;
        $result = get_data($query);
        if($result){
            foreach($result as $answers){
                $aid[] = $answers->aid;
            }
        }else{
            $aid = array();
        }
        return $aid;
    }

    public static function getToken($guid){

        $query = 'SELECT h2_token  FROM ' . elgg_get_config("dbprefix") . SHN_USER_TABLE.' WHERE elgg_user_guid ='.$guid;

        try{
             $results = get_data($query);
             echo $results[0];
        } catch (Exception $e) {
            $token ='';
        }
           return $token;

    }

    public static function saveToken($guid, $token){
        $para = array('h2_token'=>$token);
        return HRA::updateUser($guid, $para, SHN_USER_TABLE);
    }
    /*
    public static function saveHraid($guid, $hra_id){
        $para = array('guid'=>$guid, 'hra_id'=>$hra_id, 'date'=>date('m-d-Y'));
        return HRA::saveInfo($para, STAT_TABLE);
    }
    */

    public static function saveHraId($guid, $hra_id){
        $para = array('h2_hra_id'=>$hra_id, 'created'=>date('m-d-Y'));
        $result = HRA::saveInfo($para, HRA_TABLE);
        if($result){
            $user_id = H2hra::getUserId($guid);
            $para = array('shn_user_id'=>$user_id, 'shn_hra_id'=>$result, 'created'=>date('m-d-Y'));
            $result2 = HRA::saveInfo($para, STAT_TABLE);
            if($result2) {return true;}
            else{return false;}
        }else{
            return 'DB Error';
        }

    }

    public static function saveQuestion($para){
        $result= HRA::saveInfo($para, QUESTION_TABLE);
        if($result){
            return $result;
        }else{
            throw new Exception('DB input Error');
        }
    }

    public static function updateH2Question($qid, $para){
        $result= HRA::updateQuestion($qid, $para, QUESTION_TABLE);
        if($result){
            return $result;
        }else{
            throw new Exception('DB input Error');
        }
    }

    public static function saveAnswer($para){
        $result= HRA::saveInfo($para, ANSWER_TABLE);
        if($result){
            return $result;
        }else{
            throw new Exception('DB input Error');
        }
    }


    public static function updateH2Answer($aid, $para){
        $result= HRA::updateAnswer($aid, $para, ANSWER_TABLE);
        if($result){
            return $result;
        }else{
            throw new Exception('DB input Error');
        }
    }


    public static function updateBasicInfo($guid, $para){
        return HRA::updateUser($guid, $para, SHN_USER_TABLE);
    }

    public static function updateResult($guid, $hra_id, $para){
        $user_id = H2hra::getUserId($guid);
        return HRA::updateHra($user_id, $hra_id, $para, STAT_TABLE);
    }

    public static function getH2Questions($cat, $orderby=''){
        $orderby = ($orderby=='') ? ' ORDER BY h2_question_id ' : ' ORDER BY ' .$orderby ;
        $query = 'SELECT *  FROM ' . elgg_get_config("dbprefix") . QUESTION_TABLE.' WHERE category = "'.$cat.'"'.$orderby;
        $questions = (array) get_data($query);
        return $questions;
    }

    public static function getH2Answers($qid, $orderby=''){
        $orderby = ($orderby=='') ? ' ORDER BY id ' : ' ORDER BY ' .$orderby ;
        $query = 'SELECT *  FROM ' . elgg_get_config("dbprefix") . ANSWER_TABLE.' WHERE shn_hra_question_id = "'.$qid.'"'.$orderby;
        $answers = (array) get_data($query);
        return $answers;
    }
// temp
    public static function getBasicQuestions($cat, $orderby=''){
        $orderby = ($orderby=='') ? ' ORDER BY qid ' : ' ORDER BY ' .$orderby ;
        $query = 'SELECT *  FROM ' . elgg_get_config("dbprefix") . QUESTION_TABLE.' WHERE category = "'.$cat.'"'.$orderby;
        $questions = (array) get_data($query);
        return $questions;
    }

    public static function getBasicAnswers($qid, $orderby=''){
        $orderby = ($orderby=='') ? ' ORDER BY id ' : ' ORDER BY ' .$orderby ;
        $query = 'SELECT *  FROM ' . elgg_get_config("dbprefix") . ANSWER_TABLE.' WHERE qid = "'.$qid.'"'.$orderby;
        $answers = (array) get_data($query);
        return $answers;
    }

    public static function updateDatabase($table, $para){

    }
}