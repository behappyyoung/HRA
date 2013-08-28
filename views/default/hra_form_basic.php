<?php
$retry = (isset($_GET['retry'])&&($_GET['retry'])) ? true : false;

if($retry){
    $error = (isset($_GET['error'])&&($_GET['error'])) ? $_GET['error'] : '';
    $guid = $_GET["guid"];
    $token = $_GET["token"];
    $hra_id = $_GET["hra_id"];
    $gender = $_GET['gender'];
    $ethnicity = $_GET["ethnicity"];
    $weight = $_GET["weight"];
    $height = $_GET["height"];

}else{



    $guid = elgg_extract('guid', $vars, '');
    $hra_id = elgg_extract('hra_id', $vars, '');

    $userinfo = (array) H2hra::getHraUser($guid);
 //var_dump($userinfo);
    $token = $userinfo['h2_token'];


    if($hra_id==''){                // new
        $hra_id= H2hra::getAssessment($token);

      //  $hrainfo = (array) H2hra::getH2Stat($guid, 'shn_hra_id desc');
        $h2_hra_id = (array) H2hra::getH2HraId($guid);

        if($h2_hra_id[0]->h2_hra_id == $hra_id){
            //var_dump($hrainfo);
            echo 'only one time per day  [retake ? ]';
            //$answers = H2hra::getAnswers($token, $hra_id);

        }else{
            $result = H2hra::saveHraId($guid, $hra_id);
        }

    //    $questions = H2hra::getQuestions($token);
    }else{              // retake ones

        //$answers = H2hra::getAnswers($token, $hra_id);

        //$questions = H2hra::getQuestions($token, $hra_id);
    }


    $gender = $userinfo['gender'];
    $ethnicity = $userinfo["ethnicity"];
    $height = explode('.', $userinfo['height']);
    $feet = $height[0];
    $inches = $height[1];
    $weight = $userinfo["height"];



}

?>
<style>

    .form-tabs {background-image: url("<?=elgg_get_site_url()?>/mod/hra/views/default/images/firstactive.png"); height: 40px; width: 600px; font-weight: bolder;}
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
<div class="error" ><?=$error?></div>
<form class="form" id="patient-hra-form" title="Patient hra" method="post"
             action="<?php echo elgg_add_action_tokens_to_url("/action/hra/save_basic"); ?>">
    <input type="hidden" name="guid" value="<?=$guid?>" />
    <input type="hidden" name="token" value="<?=$token?>" />
    <input type="hidden" name="hra_id" value="<?=$hra_id?>" />
        <div class="form-tabs" id="form-tabs">
        </div>
         <div id="tabs-basic" class="basic-form">
              <table class="basic-form-table">
                <!-- Gender & Marital Status -->
                <tr>
                    <td class="label">
                        <span class="number"> 1 </span> <span class="required-label">Sex</span>
                    </td>
                    <td class="input">

                        <input type="radio" name="gender" value="female"  class="checkbox"  <?=($gender=='female')? 'checked=checked ':''?> > Female
                        <input type="radio" name="gender" value="male"  class="checkbox" <?=($gender=='male')? 'checked=checked ':''?> > Male
                    </td>

                </tr>
                  <tr>
                      <td  class="label">
                          <span class="number"> 2 </span> <span> Height </span>
                      </td>
                      <td class="input">

                          <input type="text" class="smallinput" name="feet"  value="<?=$feet?>" />(feet)
                          <input type="text" class="smallinput" name="inches" value="<?=$inches?>"  />(inches)
                      </td>
                  </tr>
                  <tr>
                      <td  class="label">
                          <span class="number"> 3 </span> <span> Weight </span>
                      </td>
                      <td class="input">

                          <input type="text" class="smallinput" name="weight" value="<?=$weight?>" />(Pounds)
                      </td>
                  </tr>

                  <tr>
                      <td  class="label">
                          <span class="number"> 4 </span> <span> Ethnicity </span>
                      </td>
                      <td class="input">
                          <?php echo elgg_view("shn/input/races",array(
                              "name" => "ethnicity",
                              "class" =>"",
                              "required" => "",
                              "value"=> $ethnicity
                          ));
                          ?>

                      </td>
                  </tr>



            </table>
                <div class="buttons">
                    <button class="cancel" > Cancel </button>
                    <button  class="save" > Save & Continue </button>
                </div>
            </div>
    </form>

