<style>
    .hra-table { width: 95%;border-collapse: separate; border-spacing:0 5px;}
    .hra-table tr {margin: 5px;vertical-align: middle; background-color: #d2e3ec;}
    div.clearHRA {
        clear: both;
    }
    button.retake_hra {
        border:1px solid #A72B0B;
        color:#fff;
        background:url(/mod/hra/images/retake.png) no-repeat 5px center #CC3E17;
        padding:5px 10px 5px 25px;
        float:left;
        margin:20px;
        cursor: pointer;
    }
    .col1 {width:20%;}
    .col2 {width:10%;}
    .col3 {width:10%;}
    .col4 {width:45%;}
    .hra_column {
        display:inline-block;
        float:left;
        height:auto;
        padding:5px;
        vertical-align:bottom;
        /*width: 9%;*/
    }
    .hra_row { padding:10px; border-bottom:1px solid #CCC;}
</style>
<script>

    if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4)))check = true})(navigator.userAgent||navigator.vendor||window.opera){
        // mobile
    }else{
        $( document ).tooltip();
    }

</script>

<?php

$textarray = array(
    'bmi'=>'The body mass index (BMI), is a measure for human body shape based on an individual\'s mass and height. It is used to determine whether a person is underweight, normal',
    'bmr' => 'Basal Metabolic Rate (BMR) is the amount of calories consumed by the body at rest. If you did no physical activity, this is the number of calories you would burn.',
    'aerobic'=>'This is the relative amount of oxygen that your body can effectively utilize during an intense exercise session.',
);

$patientinfo = elgg_extract('patientinfo', $vars, '');

$guid =  $patientinfo['guid'];

//check if user has taken any HRA or has account

$hrauserinfo =(array) H2hra::getHraUser($guid);
$error = '';
if(empty($hrauserinfo)){

    $result = H2hra::createAccount($patientinfo['guid'], $patientinfo['username'], $patientinfo['firstname'],
        $patientinfo['lastname'], $patientinfo['gender'], $patientinfo['email'], '1');
    if(strtoupper($result)=='OK'){
        forward(elgg_get_site_url().'hra/');
    }else{
        $error = 'Error - '. $result;
    }

}elseif($hrauserinfo['h2_token']==''){
    if(($hrauserinfo['h2_username']!='')&&( $hrauserinfo['h2_password'] != '')&&($patientinfo['guid']!='')){
        $token = H2hra::getSession($hrauserinfo['h2_username'], $hrauserinfo['h2_password']);
        $result= H2hra::saveToken($patientinfo['guid'], $token);
    }else{
        $error = 'Error - '. 'Missing Hra Username';
    }
        if($result){
            forward(elgg_get_site_url().'hra/');
        }else{
            $error = 'Error - DB input Error';
        }

}else{
    $hrainfo = (array) H2hra::getMostRecentHraStat($hrauserinfo['id']);
}

if( empty($hrainfo) )
{?>
    <br/>

    <h2>Welcome <?php echo $patientinfo['firstname'];?>,</h2>

    <?php if($error==''){ ?>

    <p>Please click the button below to take a confidential Personal Health Assessment Survey</p>
    <p>You'll receive helpful recommendations to help you achieve your Health Goals</p>
    <button onclick="<?php  echo 'window.location.href=\''.elgg_get_site_url().'hra/basic/\'';?>"
            class="retake_hra">Take Assessment</button>

<?php  }else{
            echo 'Check Your Information Please <br /> ' . $error;
    }
}
else
{


    ?>
<div class="hra-table">
    <!-- <div>HRA</div><div>date</div><div>bmi</div><div>bmr</div><div>diet plan</div><div>calories goal</div><div>strength level</div><div>fitness level</div> -->
    <?php
    foreach($hrainfo as $stat){
        /*echo '<div><div>'.$stat->shn_hra_id.'</div> <div>'.$stat->date.'</div>';
        echo '<div>'.$stat->bmi.'</div><div>'.$stat->bmr.'</div><div>'.$stat->diet_plan.'</div><div>'.$stat->calories_goal.'</div><div>'.$stat->strenth_level.'</div><div>'.$stat->fitness_classification_level.'</div>';

        echo '  <div>';
        if($stat->done){
            echo $stat->score;
        }else{
            echo '<a href="'.elgg_get_site_url().'hra/basic/'.$stat->shn_hra_id.'"> Finish </a>';
        }
        echo '</div></div>';*/
        ?>
        <!-- <div id="wrapper"> -->
        <div class="title"><h1 style="display: none;">My Health</h1>
            <button onclick="<?php  echo 'window.location.href=\''.elgg_get_site_url().'hra/basic/\'';?>"
                        >Retake Assessment</button></div>

        <div class="clearHRA"></div>
        <div class="hra_row">
            <div class="hra_column col1"><h2>BMI</h2><a title="<?=$textarray['bmi']?>">What is BMI?</a></div>
            <div class="hra_column col2"><?php echo($stat->bmi); ?></div>
            <div class="hra_column col3"><img src="<?=elgg_get_site_url()?>mod/hra/images/bmi.png" ></div>
            <div class="hra_column col4">
                <?php
                            $bmi = (float)$stat->bmi;
                        if($bmi < 18.5){
                            $bmi_image = 'underweight';
                            echo 'Your BMI is '.$bmi.', This is lower than the healthy minimum of "18.5"';

                        }elseif((18.5 <= $bmi ) &&( $bmi <= 24.9)){
                            $bmi_image = 'normal';
                            echo '"Congratulations! Your BMI is '.$bmi.', which is within the healthy range of "18.5" to "24.9".';
                        }elseif(( $bmi > 24.9)&&( $bmi < 30)){
                            $bmi_image = 'overweight';
                            echo 'Your BMI is '.$bmi.', This is above the healthy maximum of "24.9".';
                        }else{
                            $bmi_image = 'obesity';
                            echo 'Your BMI is '.$bmi.', This is above the healthy maximum of "24.9".';
                        }

                        echo '<br /><img src="'.elgg_get_site_url().'mod/hra/images/bmi_'.$bmi_image.'.png"  width="300" height="50" />';
                ?>
            </div>
            <div class="clearHRA"></div>
        </div>

        <div class="hra_row">
            <div class="hra_column col1"><h2>BMR</h2><a title="<?=$textarray['bmr']?>">What is BMR?</a></div>
            <div class="hra_column col2"><?php echo($stat->bmr); ?></div>
            <div class="hra_column col3"><img src="<?=elgg_get_site_url()?>mod/hra/images/bmr.png" width="33" height="54"></div>
            <div class="hra_column col4">Your body will burn <?php echo($stat->bmr); ?>  calories each day if you engage in no activity for the entire day</div>
            <div class="clearHRA"></div>
        </div>

        <div class="hra_row">
            <div class="hra_column col1"><h2>Nutrition Plan</h2></div>
            <div class="hra_column col2">My Diet Plan</div>
            <div class="hra_column col3"><img src="<?=elgg_get_site_url()?>mod/hra/images/dietplan.png" width="55" height="50"></div>
            <div class="hra_column col4">We've designed a personal nutrition plan to help you reach your health goals. Find it in the "Nutrition" tab at the top of your page.</div>
            <div class="clearHRA"></div>
        </div>

        <div class="hra_row">
            <div class="hra_column col1"><h2>Calories Goal</h2></div>
            <div class="hra_column col2"><?php echo($stat->calories_goal); ?></div>
            <div class="hra_column col3"><img src="<?=elgg_get_site_url()?>mod/hra/images/caloriegoal.png" width="50" height="48"></div>
            <div class="hra_column col4">Try to stay at or under this daily calorie goal to maintain a healthy weight</div>
            <div class="clearHRA"></div>
        </div>

        <div class="hra_row">
            <div class="hra_column col1"><h2>Strength Level</h2></div>
            <div class="hra_column col2"><?php
                switch($stat->strength_level){
                    case 'very_poor' :
                    case 'poor' :
                        $strenthlevel = 'Poor';
                        $strengthtext = 'Talk to your Health Coach to find the best exercises to improve your strength level';
                    break;
                    case 'Fair' :
                        $strenthlevel = 'Fair';
                        $strengthtext = 'Talk to your Health Coach to find the best exercises to improve your strength level';
                        break;
                    case 'average' :
                    case 'good' :
                        $strenthlevel = 'Good';
                         $strengthtext = 'Keep up the good work! Go ahead and continue with your favorite exercises';
                        break;
                    case 'excellent':

                        $strenthlevel = 'Excellent';
                        $strengthtext = 'Keep up the good work! Go ahead and continue with your favorite exercises';
                        break;
                }
                echo $strenthlevel; ?></div>
            <div class="hra_column col3"><img src="<?=elgg_get_site_url()?>mod/hra/images/strenght.png" width="33" height="36"></div>
            <div class="hra_column col4"><?=$strengthtext?></div>
            <div class="clearHRA"></div>
        </div>

        <div class="hra_row">
            <div class="hra_column col1"><h2>Aerobic Capacity</h2><a title="<?=$textarray['aerobic']?>">What is Aerobic Capacity?</a></div>
            <div class="hra_column col2"><?php
                switch($stat->aerobic_capacity){
                    case 'very_poor' :
                    case 'poor' :
                        $aerobic = 'Poor';
                        $aerobicText = 'Talk to your Health Coach to find the best exercises to improve your aerobic capacity';
                        break;
                    case 'average' :
                    case 'good' :
                    $aerobic = 'Good';
                        $aerobicText = 'Keep up the good work! Go ahead and continue with your favorite physical activities';
                        break;
                    case 'excellent':
                        $aerobic = 'Excellent';
                        $aerobicText = 'Keep up the good work! Go ahead and continue with your favorite physical activities';
                        break;
                }
                echo $aerobic; ?></div>

            <div class="hra_column col3"><img src="<?=elgg_get_site_url()?>mod/hra/images/aerobicapachity.png" width="43" height="52"></div>
            <div class="hra_column col4"><?=$aerobicText?></div>
            <div class="clearHRA"></div>
        </div>
        <!-- </div> -->
        <?php
        // Only just for now:
        break;
    }
    ?>
    </div>
<?php }?>

