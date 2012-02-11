<?php

defined('_JEXEC') or die('Restricted access');



require_once( dirname(__FILE__).DS.'helper.php' );



$params = moddealcategoryHelper::dealcategory($params);



require(JModuleHelper::getLayoutPath('mod_dealcategory'));



?>