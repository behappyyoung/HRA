<?php

require_once(dirname(__FILE__) . "/classes/H2hra.php");

elgg_register_event_handler('init','system','hra_init');

function hra_init() {

    elgg_register_page_handler('hra', 'hra_page_handler');
    $item = new ElggMenuItem('hra', elgg_echo('HRA'), 'hra/');
    elgg_register_menu_item('site', $item);

    $action_base_path = elgg_get_plugins_path() . 'hra/actions/patient';
    elgg_register_action("hra/save_basic", "$action_base_path/save_basic.php");
    elgg_register_action("hra/save_life", "$action_base_path/save_life.php");


}

function hra_public($hook, $handler, $return, $params) {
    $pages = array('hra');
    return array_merge($pages, $return);
}

function hra_page_handler($page) {
    $user = elgg_get_logged_in_user_entity();
    $guid =  $user->getGUID();

    $isadmin= $user->get('admin');
    $username= $user->get('username');
    $email= $user->get('email');
    $name= explode(' ', $user->get('name'));
    $guid =  $user->getGUID();
    $lastname = (sizeof($name)==3)? $name[2] : $name[1];
    $patientsMetadata = elgg_get_metadata(array(
        "metadata_names" =>  array("gender"),
        'metadata_owner_guids' =>  array($guid)
    ));

    foreach($patientsMetadata as $currentMetadata){
        $meta_export= $currentMetadata->export();
        $gender = $meta_export->getBody();
    }

    $patientinfo = array('guid'=>$guid,
                         'username'=> $username,
                            'firstname'=>$name[0],
                            'lastname'=>$lastname,
                            'gender'=>$gender,
                            'email'=>$email);

// var_dump($patientinfo);
    if (!isset($page[0])) {
        $page[0] = 'index';
    }
    $page_type = $page[0];
    $hratitle = '<img src="'.elgg_get_site_url().'/mod/hra/views/default/images/assessment_icon.png" /> Health Assessment';
    switch ($page_type) {
        case 'index':
            if($isadmin=='yes'){
                $form = elgg_view('hra_admin');
                $hratitle = '<img src="'.elgg_get_site_url().'/mod/hra/views/default/images/assessment_icon.png" /> Health Assessment Status';
            }else{
                $form = elgg_view('hra_patient', array('patientinfo'=>$patientinfo));
            }
            break;
        case 'basic':
            $form = elgg_view('hra_form_basic', array('guid'=>$guid, 'hra_id'=>$page[1]));
            $form .= 'test';
            break;
        case 'life' ;
            $form = elgg_view('hra_form_life', array('guid'=>$guid));
            $form .= 'test2';
            break;
    }


    $header = elgg_view('page/layouts/content/header', array(
        "title" => $hratitle
    ));

    $filter='';
    // Format page
    $body = elgg_view_layout("content",array(
        "content" => $form,
        "filter" => $filter,
        "header" => $header
    ));

  //  $body = elgg_view_layout('one_column', array('content' => $area));
    // Draw it
    echo elgg_view_page(elgg_echo('HRA'), $body);

    return true;
}
?>

