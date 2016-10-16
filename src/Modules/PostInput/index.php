<?php
/*
* This file is a POST interface to the application
* it will take all of HTTP POST variables, set them as environment variables,
* then it will perform a normal Bootstrap of the application
*
*/
require_once(dirname(dirname(__DIR__)).DIRECTORY_SEPARATOR."Constants.php");
$vardata = file_get_contents(PFILESDIR.PHARAOH_APP.DS.PHARAOH_APP.DS.PHARAOH_APP.'vars') ;
$vars = json_decode($vardata, true);
$fsslval = $vars["mod_config"]["ApplicationInstance"]["force_ssl"] ;
$force_ssl = (isset($fsslval) && $fsslval=="on") ? true : false ;
if ($force_ssl == true) {
    if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off"){
        $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        header('Location: ' . $redirect);
        exit(); } }

if ( !isset($_REQUEST['control']) || !isset($_REQUEST['action']) ) {
    // @todo i dont think this requires an echo
    // echo '<p>Control or Action is missing, using default</p>';
    $_REQUEST['control'] = "Index" ;
    $_REQUEST['action'] = "index" ;}
if (!isset($_REQUEST['output-format'])) { $_REQUEST['output-format'] = "HTML"; }
$cleo_vars = array();
$cleo_vars[0] = __FILE__;
$cleo_vars[1] = $_REQUEST['control'];
$cleo_vars[2] = $_REQUEST['action'];
foreach($_REQUEST as $post_key => $post_var) {
    if (!in_array($post_key, array('control', 'action'))) {
        $cleo_vars[] = "--$post_key=$_REQUEST[$post_key]" ; } }
$_ENV[PHARAOH_APP.'_bootstrap'] = serialize($cleo_vars);
include(dirname(dirname(__DIR__)).DIRECTORY_SEPARATOR."Bootstrap.php");