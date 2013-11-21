<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ypark
 * Date: 8/15/13
 * Time: 10:02 AM
 * for h2wellness nutrition APIs
 */

error_reporting(E_ALL);

define('H2_BASERUL', 'http://services.h2wellness.com/rest');
define('NUT_GET_MEAL', H2_BASERUL.'/nutrition/meals/');
define('NUT_FOOD_LIST', H2_BASERUL.'/nutrition/search/');
define('NUT_PLAN_LIST', H2_BASERUL.'/nutrition/diet_plans/');
define('NUT_SET_PLAN', H2_BASERUL.'/nutrition/set_diet_id/');


define ('SALT', 'shn_salt');
define('SHN_USER_TABLE', 'shn_users');
define('DIET_PLAN_TABLE', 'shn_diet_plan');
define('RECIPE_TABLE', 'shn_nutrition_recipe');
define('FOOD_TABLE', 'shn_nutrition_food');
define('RECIPE_FOOD_TABLE', 'shn_nutrition_recipe_food');
define('FOOD_LOG_TABLE', 'shn_nutrition_food_log');


class H2Nutrition extends H2API{

    public  static function getUserId($guid){
        $query = 'SELECT id  FROM '  . SHN_USER_TABLE.' WHERE elgg_user_guid ='.$guid;
        $hrauserinfo = get_data($query);
        if($hrauserinfo){
            return $hrauserinfo[0]->id;
        }else{
            return false;
        }

    }


    public static function getToken($guid){

        $query = 'SELECT h2_token  FROM '  . SHN_USER_TABLE.' WHERE elgg_user_guid ='.$guid;

        try{
             $results = get_data($query);
             $token= $results[0]->h2_token;
        } catch (Exception $e) {
            $token ='';
        }
           return $token;

    }

    public static function getH2Stat($guid='', $orderby='created desc'){
        $user_id = H2Nutrition::getUserId($guid);
        $hrainfo = H2API::getStat($user_id, $orderby, STAT_TABLE);
        return (array)$hrainfo[0];
    }


    public static function getMeals($token, $date){
        $datetext = '&date='.( ($date=='')? date('Y-m-d') : $date ) ;
        $getURL = NUT_GET_MEAL.'?token='.$token.$datetext;
        $output = H2API::getJsonData($getURL, '', false);
        $decodedArray = json_decode($output, true);
        $responseArray = ($decodedArray['data']['plans'][0]['meals']);
        return $responseArray;

    }

    public static function getDietPlanID($diet_plan){
        $query = 'SELECT h2_id  FROM '  . DIET_PLAN_TABLE.' WHERE h2_code ="'.$diet_plan.'"';
        $info = get_data($query);
        if($info){
            return $info[0]->h2_id;
        }else{
            return false;
        }

    }

    public static function getDietPlan($diet_plan_name){
        $query = 'SELECT *  FROM '  . DIET_PLAN_TABLE.' WHERE h2_code ="'.$diet_plan_name.'"';
        $info = get_data($query);
        if($info){
            return $info[0];
        }else{
            return false;
        }

    }

    public static function setDietPlan($token, $diet_id){
        $getURL = NUT_SET_PLAN.'?token='.$token.'&diet_id='.$diet_id;
        $output = H2API::getJsonData($getURL, '', false);
        $decodedArray = json_decode($output, true);
        $responseArray = ($decodedArray['data']['plans'][0]['meals']);
        return $responseArray;

    }


    public static function getFoods($token, $keyword){
        $keyword =  ($keyword=='')? '' : '&keyword='.$keyword ;
        $getURL = NUT_FOOD_LIST.'?token='.$token.$keyword;
        $output = H2API::getJsonData($getURL, '', false);
        $decodedArray = json_decode($output, true);
        $responseArray = ($decodedArray['data']['items']);
        return $responseArray;

    }


    public static function getPlans($token){
        $keyword =  ($keyword=='')? '' : '&keyword='.$keyword ;
        $getURL = NUT_PLAN_LIST.'?token='.$token.$keyword;
        $output = H2API::getJsonData($getURL, '', false);
        $decodedArray = json_decode($output, true);

        return $decodedArray;

    }

    public static function getRecipeID($h2id){
        $query = 'SELECT id  FROM '  . RECIPE_TABLE.' WHERE h2_id ="'.$h2id.'"';
        $info = get_data($query);
        if($info){
            return $info[0]->id;
        }else{
            return false;
        }
    }

    public static function getRecipe($rid){
        $query = 'SELECT *  FROM '  . RECIPE_TABLE.' WHERE id ="'.$rid.'"';
        $info = get_data($query);
        if($info){
            return $info[0];
        }else{
            return false;
        }
    }

    public static function addH2Recipe($recipeArray){
        $rid = H2Nutrition::getRecipeID($recipeArray['h2_id']);
        if($rid){             // exist recipe.. update
            $result = H2API::updateInfo($recipeArray, $rid, RECIPE_TABLE);
            return $rid;
        }else{                  // new add
            $result = H2API::saveInfo($recipeArray, RECIPE_TABLE);
            return $result;
        }

    }

    public static function getFoodID($h2id){
        $query = 'SELECT id  FROM '  . FOOD_TABLE.' WHERE h2_id ="'.$h2id.'"';
        $info = get_data($query);
        if($info){
            return $info[0]->id;
        }else{
            return false;
        }
    }


    public static function getFood($fid){
        $query = 'SELECT *  FROM '  . FOOD_TABLE.' WHERE id ="'.$fid.'"';
        $info = get_data($query);
        if($info){
            return $info[0];
        }else{
            return false;
        }
    }


    public static function addH2Food($foodArray){
        $fid = H2Nutrition::getFoodID($foodArray['h2_id']);
        if($fid){             // exist recipe.. update
            $result = H2API::updateInfo($foodArray, $fid, FOOD_TABLE);
            return $fid;
        }else{                  // new add
            $result = H2API::saveInfo($foodArray, FOOD_TABLE);
            return $result;
        }


    }


    public static function addH2RecipeFood($rid, $fid, $unit){
        $query = 'SELECT *  FROM '  . RECIPE_FOOD_TABLE.' WHERE recipe_id ="'.$rid.'" AND food_id ="'.$fid.'"';
        $info = get_data($query);
        if($info){             // exist recipe..food  add
            return $info[0]->id;
        }else{                  // new add
            $data = array(
                'recipe_id'=> $rid,
                'food_id' => $fid,
                'unit' => $unit
            );
            $result = H2API::saveInfo($data, RECIPE_FOOD_TABLE);
            return $result;
        }

    }

    public static function getFoodlog($id){
        $query = 'SELECT *  FROM '  . FOOD_LOG_TABLE.' WHERE id ="'.$id.'"';
        $info = get_data($query);
        if($info){
            return $info[0];
        }else{
            return false;
        }
    }

    public static function getFoodlogId($user_id, $food_id, $type, $date){
        $query = 'SELECT id  FROM '  . FOOD_LOG_TABLE.' WHERE shn_user_id ="'.$user_id.'" AND  shn_nutrition_food_id ="'.$food_id.'" AND  type ="'.$type.'" AND  date ="'.$date.'"  ';
        $info = get_data($query);
        if($info){
            return $info[0]->id;
        }else{
            return false;
        }
    }


    public static function updateFoodlog($logArray){
        $id = H2Nutrition::getFoodlogId($logArray['shn_user_id'], $logArray['shn_nutrition_food_id'], $logArray['type'], $logArray['date']);
        if($id){             // exist log.. update
            $result = H2API::updateInfo($logArray, $id, FOOD_LOG_TABLE);
            return $id;
        }else{                  // new add
            $result = H2API::saveInfo($logArray, FOOD_LOG_TABLE);
            return $result;
        }


    }


}