<?php

require_once(dirname(__FILE__) . "/classes/H2Nutrition.php");
elgg_register_event_handler('init','system','nutrition_init');

function nutrition_init() {

 //   elgg_register_widget_type('nutrition-member-stats', 'MEMBER NUTRITION STATS', 'MEMBER NUTRITION STATS');
    elgg_register_page_handler('nutrition', 'nutrition_page_handler');
    $item = new ElggMenuItem('nutrition', elgg_echo('nutrition'), 'nutrition/');
    elgg_register_menu_item('site', $item);



    $action_base_path = elgg_get_plugins_path() . 'nutrition/actions';
    elgg_register_action("nutrition/addfood", "$action_base_path/member/addfood.php");
    elgg_register_action("nutrition/addrecipe", "$action_base_path/member/addrecipe.php");

}

function nutrition_public($hook, $handler, $return, $params) {
    $pages = array('nutrition');
    return array_merge($pages, $return);
}

function nutrition_page_handler($page)
{
    $user = elgg_get_logged_in_user_entity();
    if ( empty( $user ))
    {
        error_log("Unable to acquire logged in user.");
        return false;
    }

    $guid =  $user->getGUID();
    $isadmin= $user->get('admin');
    $username= $user->get('username');
    $email= $user->get('email');
    $name= explode(' ', $user->get('name'));
    $lastname = (sizeof($name)==3)? $name[2] : $name[1];

    $patientsMetadata = elgg_get_metadata(array(
        "metadata_names" =>  array("gender"),
        'metadata_owner_guids' =>  array($guid)
    ));

    foreach($patientsMetadata as $currentMetadata){
        $meta_export= $currentMetadata->export();
        $gender = $meta_export->getBody();
    }

    $memberinfo = array('guid'=>$guid,
                         'username'=> $username,
                            'firstname'=>$name[0],
                            'lastname'=>$lastname,
                            'gender'=>$gender,
                            'email'=>$email);



    if (!isset($page[0])) {
        $page[0] = 'index';
    }
    $page_type = $page[0];
    $title = '<img src="'.elgg_get_site_url().'/mod/nutrition/views/default/images/assessment_icon.png" /> Nutrition';
    switch ($page_type) {
        case 'index':
            if($isadmin=='yes'){

                $title = '<img src="'.elgg_get_site_url().'/mod/nutrition/views/default/images/assessment_icon.png" /> Health Assessment Status';
            }else{
                $form = elgg_view('nutrition/member', array('memberinfo'=>$memberinfo));
            }
            break;

    }

    $header = elgg_view('page/layouts/content/header', array(
        "title" => $title
    ));

    $filter='';
    // Format page
    $body = elgg_view_layout("content",array(
        "content" => $form,
        "filter" => $filter,
        "header" => $header
    ));

    echo elgg_view_page(elgg_echo('NUTRITION'), $body);

    return true;
}

