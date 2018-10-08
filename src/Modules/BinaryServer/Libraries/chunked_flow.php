<?php

define('MAX_FILE_SIZE_UPLOAD', 10000000000); // 10Gb
header('Content-Type: application/json');
//
//// Make sure file is not cached (as it happens for example on iOS devices)
//header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
//header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
//header('Cache-Control: no-store, no-cache, must-revalidate');
//header('Cache-Control: post-check=0, pre-check=0', false);
//header('Pragma: no-cache');


$tmpName = $_FILES['file']['tmp_name'];
$tmpDirectory = ini_get('upload_tmp_dir') ? ini_get('upload_tmp_dir') : sys_get_temp_dir();

// Security verification
if (!is_uploaded_file($tmpName)) {
//            validationFail('bad_request', 'An error occured.');
}

$data = "this is an upload ".date('d/m/Y H:i:s') ;
file_put_contents('/tmp/pharaoh.log', $data, FILE_APPEND) ;

$data = var_export($_SERVER, true) ;
file_put_contents('/tmp/pharaoh.log', $data, FILE_APPEND) ;

$lib = dirname(__DIR__).DIRECTORY_SEPARATOR.'Libraries'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php'  ;

//        $data = var_export($_SERVER, true) ;
file_put_contents('/tmp/pharaoh.log', "LIB IS:" . $lib."\n", FILE_APPEND) ;
require_once ($lib) ;

//Path to autoload.php from current location
//        require_once './vendor/autoload.php';

file_put_contents('/tmp/pharaoh.log', 'require worked'."\n", FILE_APPEND) ;

$config = new \Flow\Config();
$config->setTempDir($tmpDirectory);
$request = new \Flow\Request();
$uploadFolder = $dir_to_write.DIRECTORY_SEPARATOR ; // Folder where the file will be stored
$uploadFileName = uniqid()."_".$request->getFileName(); // The name the file will have on the server
$uploadPath = $uploadFolder.$uploadFileName;
//        $file = new \Flow\File($config);

$data = var_export($config, true) ;
$data .= "\n\n" ;
$data .= var_export($request, true) ;
$data .= "\n\n" ;
$data .= var_export($uploadFileName, true) ;
$data .= var_export($uploadPath, true) ;
file_put_contents('/tmp/pharaoh.log', $data."\n\n\n", FILE_APPEND) ;

//        if ($file->validateChunk()) {
//            $file->saveChunk();
//        } else {
//            // error, invalid chunk upload request, retry
//            header("HTTP/1.1 400 Bad Request");
//            return ;
//        }

$res = \Flow\Basic::save($uploadPath, $config, $request) ;
file_put_contents('/tmp/pharaoh.log', "res: ".var_export($res, true) . "\n\n\n", FILE_APPEND) ;
if ($res === true) {
    // file saved successfully and can be accessed at $uploadPath
    echo "File was uploaded successfully" ;
    return true ;
} else {
    // This is not a final chunk or request is invalid, continue to upload.
    echo "Uploading Chunk\n" ;
//            return false ;
}