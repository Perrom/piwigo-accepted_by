<?php

/*
Version: 1.0
Plugin Name: Accepted_by
Author: Romain Perrouquet
Description: Plugin pour Piwigo permettant d'associer un champ "accepted_by" à une photo.
*/

// Chech whether we are indeed included by Piwigo.
if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

// Define the path to our plugin.
define('Accepted_by_PATH', PHPWG_PLUGINS_PATH.basename(dirname(__FILE__)).'/');

?>