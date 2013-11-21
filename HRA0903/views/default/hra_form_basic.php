<?php
$retry = (isset($_GET['retry'])&&($_GET['retry'])) ? true : false;

if($retry){
    $error = (isset($_GET['error'])&&($_GET['error'])) ? $_GET['error'] : '';
    $guid = $_GET["guid"];
    $token = $_GET["token"];
    $age = $_GET['age'];
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
    if( empty( $userinfo ) )
    {
        $user = elgg_get_logged_in_user_entity();
        error_log('ERROR. Uh oh. We do not have a valid user for user '. $user->guid . ' username '. $user->name);
    }
    $token = $userinfo['h2_token'];


    if($hra_id==''){                // new
        $hra_id= H2hra::getAssessment($token);

        $h2_hra_id = (array) H2hra::getH2HraId($guid);

        if($h2_hra_id[0]->h2_hra_id != $hra_id)
        {
            $result = H2hra::saveHraId($guid, $hra_id);
        }
        $h2_hra_id = $hra_id;
    }else{              // retake ones

        $h2_hra_id = H2hra::HraToH2HraId($hra_id);

    }

    $age = $userinfo['age'];
    $gender = $userinfo['gender'];
    $ethnicity = $userinfo["ethnicity"];
    $height = $userinfo['height'];
    $weight = $userinfo["weight"];
    $waist = $userinfo["waist"];
    $livingarea = $userinfo["livingarea"];


}

$feet = intval(intval($height / 12));
$inches = $height % 12;
?>
<style>

    .form-tabs {background-image: url("<?=elgg_get_site_url()?>/mod/hra/views/default/images/firstactive.png"); height: 40px; width: 600px; font-weight: bolder;}
    .basic-form .number{background-color:#cb842e; padding: 3px;margin-right: 10px;}
    .basic-form-table { width: 95%;border-collapse: separate; border-spacing:10px; display:table;}
    .basic-form-table .divrow {margin: 5px;vertical-align: middle; background-color: #d2e3ec;}
    .basic-form-table .divcell {height: 50px; margin: 5px;vertical-align: middle;padding: 10px;}
    .basic-form-table .label {width: 500px;font-weight: bolder;text-align: left; padding-left: 20px; padding-top:10px; }
    .basic-form-table .input { text-align: left; padding-left: 40px; padding-bottom: 10px;}
    .basic-form-table .smallinput  {width:100px; height: 20px; margin: 5px; font-size:11px;  padding: 1px;}
    .basic-form-table .checkbox  {width:20px; }

    .buttons {float:right;margin-right: 50px;}
    .buttons .cancel {background-color: #d0cbce;}
    .buttons .save {background-color: #9295a4;}

    .error {color: red;}


</style>

<script type="text/javascript">

    function canTakeHRA()
    {
        return true;
       //return <?= ($h2_hra_id[0]->h2_hra_id == $hra_id) ? false : true ?>
    }

    if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4)))check = true})(navigator.userAgent||navigator.vendor||window.opera){
        // mobile
    }else{
        $( document ).tooltip();
    }

</script>

<?php

/*
<div class="error" ><?=$error?></div>
*/

?>
<form class="form" id="patient-hra-form" title="Patient hra" method="post"
             onsubmit="if( canTakeHRA() )  return true; else { alert('You can only take a HRA once per day. Please try again tomorrow.'); return false; } "
             action="<?php echo elgg_add_action_tokens_to_url("/action/hra/save_basic"); ?>">
    <input type="hidden" name="guid" value="<?=$guid?>" />
    <input type="hidden" name="token" value="<?=$token?>" />
    <input type="hidden" name="h2_hra_id" value="<?=$h2_hra_id?>" />
        <div class="form-tabs" id="form-tabs">
        </div>
         <div id="tabs-basic" class="basic-form">
              <div class="basic-form-table">
                  <div class="divrow">
                      <div class="label">
                          <span class="number">1</span> <span>Age</span>
                      </div>
                      <div class="input">

                          <input type="text" name="age" size="10" style="width:auto;" value="<?=$age?>" />

                      </div>
                  </div>
                  <div class="divrow">
                    <div class="label">
                        <span class="number">2</span> <span class="required-label">Sex</span>
                    </div>
                    <div class="input">

                        <input type="radio" name="gender" value="female"  class="checkbox"  <?=($gender=='female')? 'checked=checked ':''?> > Female
                        <input type="radio" name="gender" value="male"  class="checkbox" <?=($gender=='male')? 'checked=checked ':''?> > Male
                    </div>

                </div>
                  <div class="divrow">
                      <div class="label">
                          <span class="number">3</span> <span>Height</span>
                      </div>
                      <div class="input">

                          <input type="text" name="feet"  size="10" style="width:auto;"  value="<?=$feet?>" />(feet)
                          <input type="text" name="inches"  size="10" style="width:auto;"  value="<?=$inches?>"  />(inches)
                      </div>
                  </div>
                  <div class="divrow">
                      <div  class="label">
                          <span class="number">4</span><span>Weight</span>
                      </div>
                      <div class="input">

                          <input type="text" name="weight"  size="10" style="width:auto;" value="<?=$weight?>" />(pounds)
                      </div>
                  </div>
                  <div class="divrow">
                      <div class="label">
                          <span class="number">5</span> <span title="To convert from female dress sizes to waist size, use the following conversions: size 0 = 24 in.  Size 2 = 26 in.   Size 4 = 27 in.   Size 6 = 28 in.   Size 8 = 30 in.    Size 10 = 32 in.  Size 12 =33 in.   Size 14 = 35 in.  ">Waist size (in inches)
                                <img src="<?=elgg_get_site_url()?>mod/hra/views/default/images/icon_def.png"/>
                          </span>
                      </div>
                      <div class="input">
                          <input type="text" name="waist" size="10" style="width:auto;"  value="<?=$waist?>" />(inches)
                      </div>
                  </div>
                  <div class="divrow">
                      <div  class="label">
                          <span class="number">6</span> <span>Ethnicity</span>
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
                  <div class="divrow">
                      <div  class="label">
                          <span class="number">7</span> <span>Which type of environment best describes where you live?</span>
                      </div>
                      <div class="input" >
                          <select name="livingarea">
                              <option value="city" <?php if($livingarea=='city') echo 'checked=checked';?> >Big City (300,000 +) </option>
                              <option value="mountain"  <?php if($livingarea=='mountain') echo 'checked=checked';?>  >Small City or Suburb </option>
                              <option value="suburbs"  <?php if($livingarea=='suburbs') echo 'checked=checked';?> >Small Town</option>
                          </select>
                      </div>
                  </div>
            </div>
                <div class="buttons">
                    <button  class="save" > Save & Continue </button>
                </div>
            </div>
    </form>

