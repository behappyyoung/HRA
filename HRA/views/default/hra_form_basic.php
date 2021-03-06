<?php
$retry = (isset($_GET['retry'])&&($_GET['retry'])) ? true : false;

if($retry){
    $error = (isset($_GET['error'])&&($_GET['error'])) ? $_GET['error'] : '';
    $guid = $_GET["guid"];
    $token = $_GET["token"];
    $month = $_GET["month"];
    $day = $_GET["day"];
    $year = $_GET["year"];
    $h2_hra_id = $_GET["h2_hra_id"];
    $gender = $_GET['gender'];
    $ethnicity = $_GET["ethnicity"];
    $weight = $_GET["weight"];
    $height = $_GET["height"];

    $waist = $_GET["waist"];
    $livingarea = $_GET["livingarea"];
}else{

    $guid = elgg_extract('guid', $vars, '');
    $hra_id = elgg_extract('hra_id', $vars, '');

    $userinfo = (array) H2hra::getHraUser($guid);
    $token = $userinfo['h2_token'];


    if($hra_id==''){                // new
        $hra_id= H2hra::getAssessment($token);

        $h2_hra_id = (array) H2hra::getH2HraId($guid);

        if($h2_hra_id[0]->h2_hra_id == $hra_id){
            echo 'only one time per day  [ Retake ]';

        }else{
            $result = H2hra::saveHraId($guid, $hra_id);

            $h2_hra_id = $hra_id;
        }
    }else{              // retake ones

        $h2_hra_id = H2hra::HraToH2HraId($hra_id);

    }

    $dob = explode('-', $userinfo['dob']);
    $year = $dob[0];
    $month = $dob[1];
    $day = $dob[2];
    $gender = $userinfo['gender'];
    $ethnicity = $userinfo["ethnicity"];
    $height = $userinfo['height'];
    $weight = $userinfo["weight"];
    $waist = $userinfo["waist"];
    $livingarea = $userinfo["livingarea"];


}

$height = explode('.', $height);
$feet = $height[0];
$inches = $height[1];

?>
<style>

    .form-tabs {background-image: url("<?=elgg_get_site_url()?>/mod/hra/views/default/images/firstactive.png"); height: 40px; width: 600px; font-weight: bolder;}
    .basic-form .number{background-color:#cb842e; padding: 3px;margin-right: 10px;}
    .basic-form-table { width: 95%;border-collapse: separate; border-spacing:0 5px;}
    .basic-form-table .question {float:left; width:95%; height:60px;margin: 5px;vertical-align: middle; background-color: #d2e3ec;padding:5px;}
    .basic-form-table .label {float:left;width: 150px;height:50px;font-weight: bolder;text-align: left; padding-left: 20px; }
    .basic-form-table .input {float:left; text-align: left;height:50px; padding-left: 20px; }
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
    <input type="hidden" name="h2_hra_id" value="<?=$h2_hra_id?>" />
        <div class="form-tabs" id="form-tabs">
        </div>
         <div id="tabs-basic" class="basic-form">
              <div class="basic-form-table">
                  <div class="question">
                      <div  class="label">
                          <span class="number"> 1 </span> <span> Date of Birth </span>
                      </div>
                      <div class="input">

                          <input type="text" class="smallinput" name="month" value="<?=$month?>" />
                          <input type="text" class="smallinput" name="day" value="<?=$day?>" />
                          <input type="text" class="smallinput" name="year" value="<?=$year?>" />

                      </div>
                  </div>
                <div class="question">
                    <div class="label">
                        <span class="number"> 2 </span> <span class="required-label">Sex</span>
                    </div>
                    <div class="input">

                        <input type="radio" name="gender" value="female"  class="checkbox"  <?=($gender=='female')? 'checked=checked ':''?> > Female
                        <input type="radio" name="gender" value="male"  class="checkbox" <?=($gender=='male')? 'checked=checked ':''?> > Male
                    </div>

                </div>
                  <div class="question">
                      <div  class="label">
                          <span class="number"> 3 </span> <span> Height </span>
                      </div>
                      <div class="input">

                          <input type="text" class="smallinput" name="feet"  value="<?=$feet?>" />(feet)
                          <input type="text" class="smallinput" name="inches" value="<?=$inches?>"  />(inches)
                      </div>
                  </div>
                  <div class="question">
                      <div  class="label">
                          <span class="number"> 4 </span> <span> Weight </span>
                      </div>
                      <div class="input">

                          <input type="text" class="smallinput" name="weight" value="<?=$weight?>" />(Pounds)
                      </div>
                  </div>

                  <div class="question">
                      <div  class="label">
                          <span class="number"> 5 </span> <span> Ethnicity </span>
                      </div>
                      <div class="input">
                          <?php echo elgg_view("shn/input/races",array(
                              "name" => "ethnicity",
                              "class" =>"",
                              "required" => "",
                              "value"=> $ethnicity
                          ));
                          ?>

                      </div>
                  </div>
                  <div class="question">
                      <div  class="label">
                          <span class="number"> 6 </span> <span> Waist Line Circumference (in inches) </span>
                      </div>
                      <div class="input">

                          <input type="text" class="smallinput" name="waist" value="<?=$waist?>" />(inches)
                      </div>
                  </div>
                  <div class="question">
                      <div  class="label">
                          <span class="number"> 7 </span> <span> What type of area do you live in?</span>
                      </div>
                      <div class="input">

                          <select name="livingarea">
                              <option value="city" <?php if($livingarea=='city') echo 'checked=checked';?> >Urban City</option>
                              <option value="mountain"  <?php if($livingarea=='mountain') echo 'checked=checked';?>  >Mountainous region</option>
                              <option value="suburbs"  <?php if($livingarea=='suburbs') echo 'checked=checked';?> >Suburbs</option>
                          </select>
                      </div>
                  </div>


            </div>
                <div class="buttons">
                    <button class="cancel" > Cancel </button>
                    <button  class="save" > Save & Continue </button>
                </div>
            </div>
    </form>

