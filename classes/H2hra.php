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

define('HRA_INFOTABLE', 'hra_basicinfo');
define('HRA_STATTABLE', 'hra_stat');


class H2hra extends HRA{

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

    public static function getAnswers($token, $hraID){
        $resultURL = HRA_RESULT.'?token='.$token;
        $para = array('hra_id'=>$hraID);
        $output = HRA::getJsonData($resultURL, $para, true);
        $decodedArray = json_decode($output, true);
        $responseArray = ($decodedArray['data']['response']);
        if(empty($responseArray)){
             return 'no answer for this hra';
        }else{
            return $responseArray;
        }
    }

    public static function createAccount($guid, $username, $firstname, $lastname, $gender, $email){
        $createURL = HRA_CREATE_PATIENT;
        $password = $username;
        $gender = ($gender=='')? 'M' : $gender;
        $para = array('first_name' =>$firstname,
                        'last_name'=> $lastname,
                        'gender' => $gender,
                        'email' => $email,
                        'username'=>$username,
                        'password'=>$password);

        $output = HRA::getJsonData($createURL, $para, true);

        if($output){
            $para = array_merge($para, array('guid'=>$guid));
            HRA::saveInfo($para, HRA_INFOTABLE);
            $token = H2hra::getSession($username, $password);
            saveToken($guid, $token);
        }
        return $guid. $username. $firstname. $lastname.$gender;

    }

    public static function getHraUser($guid){

       $query = 'SELECT *  FROM ' . elgg_get_config("dbprefix") . HRA_INFOTABLE.' WHERE guid ='.$guid;
        $hrauserinfo = get_data($query);
        return $hrauserinfo[0];

    }

    public static function getHraStat($guid=''){
        $subquery = ($guid=='') ? '' : ' WHERE guid = ' .$guid ;
        $query = 'SELECT *  FROM ' . elgg_get_config("dbprefix") . HRA_STATTABLE.$subquery;
        $hrainfo = get_data($query);
        return $hrainfo;

    }

    public static function getToken($guid){

        $query = 'SELECT token  FROM ' . elgg_get_config("dbprefix") . 'hra_basicinfo WHERE guid ='.$guid;

        try{
             $results = get_data($query);
             echo $results[0];
        } catch (Exception $e) {
           // $token = 'Error : '.$e->getMessage();
            $token ='';
        }
           return $token;

    }

    public static function saveToken($guid, $token){
        $para = array('token'=>$token);
        return HRA::updateInfo($para, $guid);
    }
    public static function saveHraid($guid, $hra_id){
        $para = array('guid'=>$guid, 'hra_id'=>$hra_id, 'date'=>date('m-d-Y'));
        return HRA::saveInfo($para, HRA_STATTABLE);
    }
}