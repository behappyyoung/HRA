<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ypark
 * Date: 8/16/13
 * Time: 4:13 PM
 * To change this template use File | Settings | File Templates.
 */

var_dump($_REQUEST);
exit();
    $forwardURL = elgg_get_site_url().'/hra/finish';

forward($forwardURL);
