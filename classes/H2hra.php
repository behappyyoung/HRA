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


class H2hra extends HRA{

    public static function getSession(){

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
        $ch = curl_init($assessmentURL);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_POST,false);        // post not working as of 8/15
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = substr($output, strpos($output, '{'));
        if($output){
            $decodedArray = json_decode($output, true);
            $hraID = ($decodedArray['data']['response']['hra_id']);

            return $hraID;
        }else{
            return false;
        }

    }

    public static function getAnswers($token, $hraID){
        $resultURL = HRA_RESULT.'?token='.$token;
        $ch = curl_init($resultURL);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_POST,true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, 'hra_id='.$hraID);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = substr($output, strpos($output, '{'));
        if($output){
            $decodedArray = json_decode($output, true);
            $responseArray = ($decodedArray['data']['response']);
            if(empty($responseArray)){
                return 'no answer for this hra';
            }else{
                return $responseArray;
            }

        }else{
            return false;
        }

    }

    public static function createAccount($guid, $username, $firstname, $lastname){
        return $guid. $username. $firstname. $lastname;
    }

}