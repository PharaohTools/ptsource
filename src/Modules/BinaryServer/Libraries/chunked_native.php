<?php

if (isset($_SERVER['HTTP_CONTENT_RANGE']) && !empty($_SERVER['HTTP_CONTENT_RANGE']) && isset($_SERVER['CONTENT_LENGTH']) && is_numeric($_SERVER['CONTENT_LENGTH'])) {

    $data = "this is ina range".date('d/m/Y H:i:s') ;

    file_put_contents('/tmp/pharaoh.log', $data, FILE_APPEND) ;

    // We get the size of the file uploaded from the client (real, final size)
    $filesize = intval(substr($_SERVER['HTTP_CONTENT_RANGE'], strpos($_SERVER['HTTP_CONTENT_RANGE'], '/') + 1));

//            if ($filesize > MAX_FILE_SIZE_UPLOAD) {
//                validationFail('bad_request', 'File size allowed must be lower than 10Mb.');
//            }

    if (isset($_SESSION['filename']) && is_file($tmpDirectory.'/'.$_SESSION['filename'])) {
        file_put_contents($tmpDirectory.'/'.$_SESSION['filename'], fopen($tmpName, 'r'), FILE_APPEND);
        unlink($tmpName); // We delete the file once we copied it, in order to not use unecessary storage

        // We stop here if the file is not completely loaded
        $currentSize = filesize($tmpDirectory.'/'.$_SESSION['filename']);
        if ($currentSize < $filesize) {
            echo ('{"size": '.$currentSize.'}');
            $res = false ;
        } else {
            $tmpName = $tmpDirectory.'/'.$_SESSION['filename'];
        }
    } else {
        $_SESSION['filename'] = uniqid().'.csv.part';
        move_uploaded_file($tmpName, $tmpDirectory.DIRECTORY_SEPARATOR.$_SESSION['filename']);
        echo('{"size": '.filesize($tmpDirectory.DIRECTORY_SEPARATOR.$_SESSION['filename']).'}');
        $res =  true ;
    }
}
