<?php

require_once 'google-api-php-client/autoload.php';

class Google_Cloud_Storage {
	
    public function startTriger($input){

	$clientId = $input['Client-Id'];
	$clientSecret = $input['Client-Secret']; 
	$redirectUri = $input['Redirect-Uri'];
	$developerKey = $input['Developer-Key'];
	$projectId = $input["Project-Id"];
	$bucketName = $input['Bucket-Name'];
	$objectName = $input['Object-Name'];
	

	session_start();

	$client = new Google_Client();
	$client->setApplicationName("Google Cloud Storage PHP Starter Application");
	$client->setClientId("$clientId");
	$client->setClientSecret("$clientSecret");
	$client->setRedirectUri("$redirectUri");
	$client->setDeveloperKey("$developerKey");
	$client->setScopes('https://www.googleapis.com/auth/devstorage.full_control');

	$storageService = new Google_Service_Storage($client);

	define('API_VERSION', 'v1');

	$file="Hello";//file to upload	
	$StorageService = new Google_Service_Storage($client);
	$objects = $StorageService->objects;
	$postbody = array('data' => "$file");
	$gso = new Google_Service_Storage_StorageObject();
	$gso->setName("$objectName");
	$resp = $objects->insert("$bucketName", $gso ,$postbody);
//	print_r($resp);
    }
}
