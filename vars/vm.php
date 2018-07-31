<?php

require(__DIR__.DIRECTORY_SEPARATOR.'default.php') ;
$variables['vmname'] = 'pharaoh_'.$variables['application_slug'] ;
$variables['desktop_app_slug'] = $variables['vmname'] ;
$variables['android_shell_script'] = 'vm-android-shell.bash' ;
$variables['custom_branch'] = 'development' ;
$variables['env_level'] = 'dev' ;
$variables['description_vm_image'] = 'The PTV VM Image for '.$variables['description'] ;

$variables['pharaoh_repo_auth_user'] = '' ;
$variables['pharaoh_repo_auth_pw'] = '' ;
$variables['pharaoh_repo_auth_url'] = '' ;

# Developer build (Virtual Machine) can use a back end of either local (VM) or devcloud
//var_dump('vm vars', __DIR__.DIRECTORY_SEPARATOR.'default.php', $variables) ;

