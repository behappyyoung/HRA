<?php
$guid = elgg_extract('guid', $vars, '');
$hra_id = elgg_extract('hra_id', $vars, '');

$userinfo = (array) H2hra::getHraUser($guid);
$token = $userinfo['token'];


echo $hra_id;
if($hra_id==''){                // new
    $hra_id= H2hra::getAssessment($token);

    $hrainfo = (array) H2hra::getHraStat($guid);
    if($hrainfo[0]->hra_id == $hra_id){
        //var_dump($hrainfo);
        echo 'only one time per day  [retake ? ]';
    }else{
        $result = H2hra::saveHraid($guid, $hra_id);
    }

    $questions = H2hra::getQuestions($token);
}else{              // retake ones

    $answers = H2hra::getAnswers($token, $hra_id);
var_dump($answers);
    //$questions = H2hra::getQuestions($token, $hra_id);
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


</style>
<form class="form" id="patient-hra-form" title="Patient hra" method="post"
             action="<?php echo elgg_add_action_tokens_to_url("/action/hra/save_basic"); ?>">
        <div class="form-tabs" id="form-tabs">
        </div>
         <div id="tabs-basic" class="basic-form">
              <table class="basic-form-table">
                <!-- Gender & Marital Status -->
                <tr>
                    <td  class="label">
                        <span class="number"> 1 </span> <span> Age </span>
                    </td>
                    <td class="input">

                        <input type="text" class="smallinput" name="age"  />
                    </td>
                </tr>
                <tr>
                    <td class="label">
                        <span class="number"> 2 </span> <span class="required-label">Sex</span>
                    </td>
                    <td class="input">

                        <input type="radio" name="gender" value="1"  class="checkbox" > Female
                        <input type="radio" name="gender" value="2"  class="checkbox"> Male
                    </td>

                </tr>
                  <tr>
                      <td  class="label">
                          <span class="number"> 3 </span> <span> Height </span>
                      </td>
                      <td class="input">

                          <input type="text" class="smallinput" name="feet"  />(feet)
                          <input type="text" class="smallinput" name="inches"  />(inches)
                      </td>
                  </tr>
                  <tr>
                      <td  class="label">
                          <span class="number"> 4 </span> <span> Weight </span>
                      </td>
                      <td class="input">

                          <input type="text" class="smallinput" name="pounds"  />(Pounds)
                      </td>
                  </tr>
                  <tr>
                      <td  class="label">
                          <span class="number"> 5 </span> <span> Ethnicity </span>
                      </td>
                      <td class="input">
                          <?php echo elgg_view("shn/input/races",array(
                              "type" => "radio",
                              "name" => "race",
                              "class" =>"checkbox",
                              "required" => ""
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

