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

var test;
function showItemlist(items){
    //  $('#items').html ( 'here is the result <br />' + jQuery.parseJSON(items) );
    var itemlist = '';
    var jitem ='';
    for (var item in items){
    jitem = JSON.stringify(items[item]);
    test=JSON.stringify(items[item]);
    itemlist += '<div class="inditem"  id="'+items[item].id+'" onclick="addFooditem('+jitem+');addFoodlist(\''+items[item].name+'\');">'+ items[item].name + '</div>';
    }

$('#items').html ( itemlist );
}

function addFooditem(fitem){
    alert(fitem);
    $('#fitem').val ( fitem);

    }

function addFoodlist(fitem){
    $('#keyword').val ( fitem);
    }
function addingFood(){
    var fid = $('#fid').val();
    var when = $('#when').val();
    var fname = $('#keyword').val();

    $.ajax({
    type : "POST",
    url : "<?php echo elgg_add_action_tokens_to_url('/action/nutrition/addfood');?>",
    data : {fid : fid, when : when, fname : fname },
success : function(data){
    alert(data);
    }

});
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
