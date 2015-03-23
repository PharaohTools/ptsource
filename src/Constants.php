<?php

/**
 * Pharaoh Tools Constants
 */

define('PHARAOH_APP', "ptbuild") ;

if (in_array(PHP_OS, array("Windows", "WINNT"))) {
    $sd = getenv('SystemDrive') ;
    $pf = getenv('ProgramFiles') ;
    $pf = str_replace(" (x86)", "", $pf) ;
    $command = "where /R \"{$pf}\" *VBoxManage* " ;
    $outputArray = array();
    exec($command, $outputArray);
    define('VBOXMGCOMM', "\"{$outputArray[0]}\" ") ;
    define('PFILESDIR', $sd."\\PharaohTools\\") ;
    define('PTCCOMM', PFILESDIR.'ptconfigure.cmd"') ;
    define('PTDCOMM',  PFILESDIR."ptdeploy.cmd") ;
    define('PHLCOMM',  PFILESDIR."phlagrant.cmd") ;
    define('PHRCOMM',  PFILESDIR."ptbuild.cmd") ;
    define('HORCOMM',  PFILESDIR."horus.cmd") ;
    define('RACOMM',  PFILESDIR."ra.cmd") ;
    define('BOXDIR', $sd.'\\PharaohTools\boxes') ;
    define('PIPEDIR', $sd.'\\PharaohTools\pipes'.'\\') ;
	define('PLUGININS', $sd.'\\PharaohTools\plugins/installed'.'\\') ;
    define("DS", "\\");
    define("BASE_TEMP_DIR", getenv("SystemDrive").'\Temp\\'); }
else if (in_array(PHP_OS, array("Linux", "Solaris", "FreeBSD", "OpenBSD", "Darwin"))) {
    define('DS', "/") ;
    define('VBOXMGCOMM', "vboxmanage ") ;
    define('PFILESDIR', "/opt/") ;
    define('PTCCOMM', "ptconfigure ") ;
    define('PTDCOMM', "ptdeploy ") ;
    define('PHLCOMM', "phlagrant") ;
    define('PHRCOMM', "ptbuild") ;
    define('HORCOMM', "horus") ;
    define('RACOMM', "ra") ;
    define("BASE_TEMP_DIR", '/tmp/');
    define('BOXDIR', '/opt/phlagrant/boxes') ;
    define('PIPEDIR', '/opt/ptbuild/pipes') ;
    define('PLUGININS', '/opt/ptbuild/plugins/installed') ; }