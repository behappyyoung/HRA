
<?php

$memberinfo = elgg_extract('memberinfo', $vars, '');

$guid =  $memberinfo['guid'];

$token = H2Nutrition::getToken($guid);

$userstat = H2Nutrition::getH2Stat($guid);


?>
<style>

    .meals {display: inline-block; width: 335px; height:140px; padding:5px;}

    .meals:hover div {visibility: visible;}

    .detail {        /* opacity setting */

        width:330px;
        height:130px;

        /* hide it by default */
        display:none;
        background:#000;
        color:#fff;
        font-weight:bold;
    filter:alpha(opacity=60);    /* ie  */
    -moz-opacity:0.6;    /* old mozilla browser like netscape  */
    -khtml-opacity: 0.6;    /* for really really old safari */
    opacity: 0.6;    /* css standard, currently it works in most modern browsers like firefox,  */
        }


     .jcarousel-clip {overflow: hidden;width: 690px;}
    .jcarousel-prev {float:left; margin: 5px 20px;}
    .jcarousel-next{ float: right;margin: 5px 20px;}
    .content { width:700px;}
    .plantitle { background: #576c80; color: white;width: 675px; font:16px bolder; height: 30px;padding:5px; }
    .calsum { width: 675px; font:14px bolder; height: 100px;padding:5px; }
    .calind { width:150; font:14px bolder; padding:5px;display: inline-block;  }
    .recipe_name { background: #a3b8da;width: 675px; font:14px bolder; height: 30px;padding:5px; }
    .foodlist { width: 675px; font:14px bolder; height: 30px;padding:5px; }
    .Breakfast {background: url("<?php echo $CONFIG->url?>mod/nutrition/images/breakfast.jpg") no-repeat;}
    .Lunch {background: url("<?php echo $CONFIG->url?>mod/nutrition/images/lunch.jpg") no-repeat;}
    .Dinner {background: url("<?php echo $CONFIG->url?>mod/nutrition/images/dinner.jpg") no-repeat;}
    .AMSnack {background: url("<?php echo $CONFIG->url?>mod/nutrition/images/amsnack.jpg") no-repeat;}
    .PMSnack {background: url("<?php echo $CONFIG->url?>mod/nutrition/images/pmsnack.jpg") no-repeat;}
    .EvSnack {background: url("<?php echo $CONFIG->url?>mod/nutrition/images/evsnack.jpg") no-repeat;}
    .rightspan { float: right;}
    .add {background: red;background: url("<?php echo $CONFIG->url?>mod/nutrition/images/btn_add.png") no-repeat; width: 96px; height: 26px;text-align: center; vertical-align: middle;}

    #addfood { display: none; ; position: absolute; left:100px; top: 100px; width: 500px; height: 300px; border: solid blue;background: white; }
    #addfood_title { background-color: #6c83a6; padding: 3px 0;height: 30px;}
    #iteminput { margin: 10px;}
    #items {overflow-y: auto; ; height: 150px; width: 450px;}
    .inditem:hover {background: red;}
    #recipe_title { background-color: #4C5865; padding:10px; color: #fff; font-size: 16px;}
    .recipe_title { padding: 10px; background: #EDEFF0; border: 1px solid #C5C5C5; border-top:0px;}
    .food_log_wrapper{ border: 1px solid #C5C5C5;}
    .block_nutrition { padding: 10px; border: 1px solid #C5C5C5; border-top:0px; }



    .ing {display: inline-block; width: 130px; height: 100px; border: solid 2px grey; }
    .ing span {display: inline-block; position: relative; left:90px; top:70px; font: 20px bolder;}
    div.protein {background: url("<?php echo $CONFIG->url?>mod/nutrition/images/protein.png") no-repeat; }
    div.fat {background: url("<?php echo $CONFIG->url?>mod/nutrition/images/fat.png") no-repeat;}
    div.carbs {background: url("<?php echo $CONFIG->url?>mod/nutrition/images/carbs.png") no-repeat;}
    div.fiber {background: url("<?php echo $CONFIG->url?>mod/nutrition/images/fiber.png") no-repeat;}
    div.calories {background: url("<?php echo $CONFIG->url?>mod/nutrition/images/calories.png") no-repeat;}
    .fats, .carbs , .fiber, .calories { border-left: 1px solid #ACACAC; }
    .rtitle { color : #E04F0F;}
    .popuprow { padding: 10px 0;}
    .rtitle { color : red;}



    span.name {display: block; width:280px; float: left;}
    span.amount {display:block; width:100px; float: left;}
    span.pro {display: block; width:50px; float: left;}
    span.fat {display: block; width:50px; float: left;}
    span.carb {display:block; width:50px; float: left;}
    span.fib {display: block; width:50px; float: left;}
    span.cal {display: block; width:50px; float: left;}

</style>

<script type="text/javascript" src="<?php echo $CONFIG->url?>mod/nutrition/vendors/jquery.jcarousel.min.js"></script>
<script>
    jQuery(document).ready(function() {
        jQuery('#mycarousel').jcarousel({
            // Configuration goes here
            wrap: 'circular',
            scroll : 2
        });
//move the image in pixel
        var move = -15;

//zoom percentage, 1.2 =120%
        var zoom = 1.2;

//On mouse over those thumbnail
        $('.meals').hover(function() {

                //Set the width and height according to the zoom percentage
                width = $('.meals').width() * zoom;
                height = $('.meals').height() * zoom;

                //Move and zoom the image
                $(this).find('img').stop(false,true).animate({'width':width, 'height':height, 'top':move, 'left':move}, {duration:200});

//Display the caption
                $(this).find('div.detail').stop(false,true).fadeIn(200);
            },
            function() {
                //Reset the image
                $(this).find('img').stop(false,true).animate({'width':$('.item').width(), 'height':$('.item').height(), 'top':'0', 'left':'0'}, {duration:100});

//Hide the caption
                $(this).find('div.detail').stop(false,true).fadeOut(200);
            });
    });
    function AddFood(){
        $('#addfood').css("display", "block");
    }
    function closeDiv(){
        $('#addfood').css("display", "none");
    }
    $('#keyword').live("keyup", function() {
        var keywords = $(this).val();
        if(keywords.length > 2 ){
            var token="<?=$token?>";
            var searchUrl = "<?=NUT_FOOD_LIST?>?token="+token +"&keyword="+keywords+"*";
            $.ajax({
                type : "GET",
                url : searchUrl,
                dataType: "json",
                success : function(data){
                    showItemlist(data.data.items);
                },
                error : function(msg){
                    //        alert ('error' + msg);
                    $('#items').html ( 'No Result' );
                }

            });

        }

    });

    function showItemlist(items){
        //  $('#items').html ( 'here is the result <br />' + jQuery.parseJSON(items) );
        var itemlist = '';
        var foodinfo = {};
console.log(items);
        for (var item in items){

            foodinfo =  items[item].id + '/' + items[item].name +'/'+ items[item].calories +'/'+ items[item].protein +'/'+ items[item].fat +'/'+ items[item].carb +'/'+ items[item].fiber +'/'+ items[item].unit +'/'+ items[item].quantity  ;
            itemlist += '<div class="inditem"  id="'+items[item].id+'" onclick="addFooditem(\''+foodinfo+'\');">'+ items[item].name + '</div>';
        }

        $('#items').html ( itemlist );
    }

    function addFooditem(foodinfo){
        var foodarray =foodinfo.split('/');
        $('#keyword').val ( foodarray[1]);

        $('#fid').val ( foodarray[0]);
        $('#fcal').val ( foodarray[2]);
        $('#fpro').val ( foodarray[3]);
        $('#ffat').val ( foodarray[4]);
        $('#fcarb').val ( foodarray[5]);
        $('#ffib').val ( foodarray[6]);
        $('#funit').val ( foodarray[7]);
        $('#amount').val ( foodarray[8]);

    }

    function addingFood(){
        var guid = $('#guid').val();
        var fid = $('#fid').val();
        var when = $('#when').val();
        var fname = $('#keyword').val();
        var fcal = $('#fcal').val();
        var fpro = $('#fpro').val();
        var ffat = $('#ffat').val();
        var fcarb = $('#fcarb').val();
        var ffib = $('#ffib').val();
        var funit = $('#funit').val();
        var amount = $('#amount').val();



        $.ajax({
            type : "POST",
            url : "<?php echo elgg_add_action_tokens_to_url('/action/nutrition/addfood');?>",
            data : {guid : guid, fid : fid, when : when, fname : fname, fcal : fcal, fpro : fpro, ffat : ffat, fcarb : fcarb, ffib : ffib, funit : funit , amount : amount},
            success : function(data){
                if(data){
                    $('#bfastdiv').append('<span class="name"> '+ fname +' </span><span class="amount">  '+ amount + funit +' </span><span class="pro">  '+ Number(fpro).toFixed(2) +' </span> <span class="fat">  '+ ffat +' </span>' +
                        ' <span class="carb"> '+ fcarb +'  </span> <span class="fib">  '+ ffib +' </span> <span class="cal">  '+ Number(fcal).toFixed(2) +' </span>'  );
                }else{
                    alert ( 'ERROR ');
                }
            }

        });

        $('#addfood').fadeOut();
    }

    function addRecipe(recipe_id){
        $.ajax({
            type : "POST",
            url : "<?php echo elgg_add_action_tokens_to_url('/action/nutrition/addrecipe');?>",
            data : {recipe_id : recipe_id},
            success : function(data){
                alert(data);
            }

        });
    }

    function addNutritions(){

    }

</script>
<div class="content">
<?php


if($userstat['calories_goal']!=''){

    $calory_goal = $userstat['calories_goal'];
    echo '<div class="plantitle"> My Calories Summary </div>';
    echo '<div class="calsum"> <div class="calind"> calories goal  <br />'.$calory_goal .'</div> <div class="calind"> calories goal  <br />'.$calory_goal .'</div>
    <div class="calind"> calories goal  <br />'.$calory_goal .'</div> <div class="calind"> calories goal  <br />'.$calory_goal .'</div> </div>';

}else{
    echo 'You don\'t have Calories Goal <br />';
   echo '<a href="'.elgg_get_site_url().'hra/"> Retake HRA </a> <br />';

}


$totalcal = 0;
if($userstat['diet_plan']!=''){
    $diet_plan_name = $userstat['diet_plan'];

   $diet_plan = H2Nutrition::getDietPlan($diet_plan_name);

   // echo 'Diet Plan : '. $diet_plan->h2_name . '<br />';
    echo '<div class="plantitle"> My Recommended Recipes </div>';
   $meals = H2Nutrition::setDietPlan($token, $diet_plan->h2_id);  // may not need later
if(empty($meals)){
    $meals = H2Nutrition::getMeals($token, date('Y-m-d'));
}


   echo '<div class="jcarousel-skin-name"> <div class="jcarousel-container"> <div class="jcarousel-clip">    <ul   id="mycarousel"  class="jcarousel-list"> ';
    $foodArray = array();

   foreach($meals as $meal){
       $recipeId = $meal['id'];
       $recipeName = $meal['name'];
       $mealtype = $meal['title'];
       $direction = ($meal['direction']!='')? $meal['direction'] : $meal['mealitems'][0]['directions'] ;
           $recipeArray = array ( 'name' => $recipeName,
                        'h2_id' => $recipeId ,
                       'h2_name' => $recipeName,
                        'type' => $mealtype,
                        'direction' => $direction );

       if($recipeName!=''){
           echo '<li class="jcarousel-item-1"><div class="meals '.str_replace(".", "", str_replace(" ", "",$meal['title'])).'"><div class="detail">'. $meal['title'].'  : '. $meal['name'];

                foreach($meal['meal_nutrients'] as $key => $value){

                    if($key=='Cal') {
                        $totalcal += $value;
                        echo $key.'  --- '.$value .'<br />';
                        $recipeArray['Cal'] = $value;
                    }elseif(($key=='Carb')||($key=='Pro')||($key=='Fat')||($key=='Fib')){
                        echo $key.'  --- '.$value .'<br />';
                        $recipeArray[$key] = $value;
                    }
                }


           $recipe_id = H2Nutrition::addH2Recipe($recipeArray);      // update DB for later use.   // return Recipe shn id
           if($recipe_id){
               foreach($meal['mealitems'] as $mealitems){
                   foreach ($mealitems['subitems'] as $food ){          // food items
                       $foodArray = array(
                           'name' => $food['name'],
                           'h2_id' => $food['id'],
                            'h2_name' => $food['name'],
                       );
                       foreach($food['item_nutrient'][0] as $key => $value){
                           if(($key=='Cal')||($key=='Carb')||($key=='Pro')||($key=='Fat')||($key=='Fib')){
                               $foodArray[$key] = $value;
                           }
                       }

                    $food_id = H2Nutrition::addH2Food($foodArray);      // update DB for later use.   // return Food shn id
                    $result = H2Nutrition::addH2RecipeFood($recipe_id, $food_id, $food['unit']);
                    }

               }
           }

           echo ' <span class="rightspan add " onclick="addRecipe('.$recipe_id.');"> Add This </span> </div>  </div></li>';
       }


   }

     echo '</ul></div> <div class="jcarousel-prev"> PRE </div>  <div class="jcarousel-next"> NEXT </div></div></div>';
    echo '<div> <br />total calories : '.$totalcal .'</div>';

}else{
    echo ' We don\'t have Diet Recommendation for you <br />';
    echo '<a href="'.elgg_get_site_url().'hra/"> Retake HRA </a> <br />';

}



//$food =  H2Nutrition::getFoods($token,'');

//var_dump($food);

//var_dump( H2Nutrition::getPlans($token) );




?>


    <div id="addfood">
        <div id="addfood_title"> Add Food <span class="rightspan" onclick="closeDiv();"> close X </span> </div>
        <div id="iteminput">
            <div class="popuprow">
                <label> When ?</label>

            <select id="when" name="when" >
                <option value="breakfast" > Breakfast</option>
                <option value="amsnack" > A.M. Snack </option>
                <option value="lunch" > Lunch </option>
                <option value="pmsnack" > P.M. Snack </option>
                <option value="dinner" > Dinner </option>
                <option value="evsnack" > Ev. Snack </option>
            </select>
            </div>
            <div class="popuprow">

            What did you eat today ? <input id="keyword" name="keyword" type="text"/>

                <input id="fid" name="fitem" type="hidden"/>
                <input id="fcal" name="fcal" type="hidden"/>
                <input id="fpro" name="fpro" type="hidden"/>
                <input id="ffat" name="ffat" type="hidden"/>
                <input id="fcarb" name="fcarb" type="hidden"/>
                <input id="ffib" name="ffib" type="hidden"/>
                <input id="funit" name="funit" type="hidden"/>
                <input id="amount" name="amount" type="hidden"/>
                <input id="guid" name="guid" type="hidden" value="<?=$guid?>"/>
            </div>

            <div id="items" >  </div>
            <div class="rightspan add"  onclick="addingFood();">Add Food </div>
        </div>

    </div>

    <div id="foodlog">
        <?php include_once("foodlog.php"); ?>
    </div>
</div>
