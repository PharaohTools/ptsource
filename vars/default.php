<?php

$variables = array() ;
$variables['application_slug'] = 'build' ;
$variables['random_port_suffix'] = '57' ;
$variables['domain'] = 'pharaohtools.vm' ;
$variables['full_slug'] = 'pt'.$variables['application_slug'] ;
$variables['description'] = 'Pharaoh '.ucfirst($variables['application_slug']).' Development VM' ;
$variables['subdomain'] = $variables['application_slug'] ;
$variables['webclientsubdomain'] = $variables['application_slug'] ;
$variables['server_subdomain'] = 'server' ;
$variables['friendly_app_slug'] = $variables['application_slug'] ;
$variables['desktop_app_slug'] = $variables['friendly_app_slug'] ;
