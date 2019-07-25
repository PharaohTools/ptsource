<?php

//var_dump($pageVars["data"]) ;

$ht_string = ($pageVars["data"]["is_https"] == true) ? 'HTTPS' : 'HTTP' ;
$ht_string_lower = strtolower($ht_string) ;
$port_string = ($_SERVER['SERVER_PORT'] !== '80') ? ':'.$_SERVER['SERVER_PORT'] : '' ;
$ownerOrPublic = (isset($pageVars["data"]["repository"]["project-owner"]) &&
    strlen($pageVars["data"]["repository"]["project-owner"])>0) ?
    $pageVars["data"]["repository"]["project-owner"] : "public" ;

foreach ($pageVars["data"]["repositories"] as &$repository) {
    $repository['git_http_url'] = "{$ht_string_lower}://{$pageVars["data"]["user"]['username']}:{password}@{$_SERVER["SERVER_NAME"]}{$port_string}/git/{$ownerOrPublic}/{$repository["project-slug"]} " ;
    $repository['git_ssh_url'] = "ssh://ptgit@{$_SERVER["SERVER_NAME"]}/git/{$ownerOrPublic}/{$repository["project-slug"]} " ;
}


$return = ['repositories' => $pageVars["data"]["repositories"]] ;

$json = json_encode($return, JSON_PRETTY_PRINT) ;

echo $json ;