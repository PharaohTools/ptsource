<?php
/*
* This file is a POST interface to the application
* it will take all of HTTP POST variables, set them as environment variables,
* then it will perform a normal Bootstrap of the application
*
*/
if ( !isset($_REQUEST['control']) || !isset($_REQUEST['action']) ) {
    echo '<p>Control or Action is missing, using default</p>';
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
$_ENV['cleo_bootstrap'] = serialize($cleo_vars);
include("../../Bootstrap.php");