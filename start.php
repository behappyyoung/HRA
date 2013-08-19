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

    if (!isset($page[0])) {
        $page[0] = 'index';
    }
    $page_type = $page[0];
    switch ($page_type) {
        case 'index':
            $form = elgg_view('hra_patient');

            break;
        case 'basic':
            $form = elgg_view('hra_form_basic');
            $form .= 'test';
            break;
        case 'life' ;
            $form = elgg_view('hra_form_life');
            $form .= 'test2';
            break;
    }


    $header = elgg_view('page/layouts/content/header', array(
        "title" => '<img src="'.elgg_get_site_url().'/mod/hra/views/default/images/assessment_icon.png" /> Health Assessment'
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

