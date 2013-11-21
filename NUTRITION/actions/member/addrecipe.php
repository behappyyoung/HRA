<?php
/**
 * Created by JetBrains PhpStorm.
 * User: young
 * Date: 9/16/13
 * Time: 3:13 PM
 * To change this template use File | Settings | File Templates.
 */

$recipe_id= $_REQUEST['recipe_id'];

if(empty($recipe_id)){
    // user input
    return 'Error : No Recipe Information ';

}else{
    // get food from H2

    echo $recipe_id;
}

exit();
?>