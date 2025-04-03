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

global $prefixeTable;
define('ACCEPTED_BY', $prefixeTable.'accepted_by'); // The db

// Hook on to an event to show the administration page.
add_event_handler('get_admin_plugin_menu_links', 'accepted_by_admin_menu');

// Add an entry to the 'Plugins' menu.
function accepted_by_admin_menu($menu) {
    array_push(
      $menu,
      array(
        'NAME'  => 'Accepted_by',
        'URL'   => get_admin_plugin_menu_link(dirname(__FILE__)).'/admin.php'
      )
    );
    return $menu;
}

// Add information to the picture's description
include_once(dirname(__FILE__).'/image.php');

// Add the Accepted_by dropdown menu to picture_modify
include_once(dirname(__FILE__).'/modify.php');

?>