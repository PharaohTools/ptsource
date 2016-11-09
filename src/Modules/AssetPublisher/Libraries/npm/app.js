/*
 * Demo of UI interaction with jQuery+Uniter
 *
 * MIT license.
 */
'use strict';

var $ = require('jquery'),
    fileData = require('../../../PostInput/Assets/Modules/DefaultSkin/js/fileData.js'),
    mainFiles = require('../../../PostInput/Assets/Modules/DefaultSkin/js/mainFiles.js'),
    hasOwn = {}.hasOwnProperty,
    uniter = require('uniter'),
    phpEngine = uniter.createEngine('PHP'),
    output = document.getElementById('output');

var file_require_string = "" ;
mainFiles.forEach(function (filePath) {
    filePath = filePath.replace("/opt/pttrack/pttrack/src/Modules/", "../../");
    file_require_string += 'require("'+filePath+'") ; ';
});

function getFileData(path) {
    if (!hasOwn.call(fileData, path)) {
        throw new Error('Unknown file "' + path + '"');
    }
    return fileData[path];
}

// Set up a PHP module loader
phpEngine.configure({
    include: function (path, promise) {
        promise.resolve(getFileData(path));
    }
});

// Expose jQuery to PHPland
phpEngine.expose($, 'jQuery');

// Expose Window to PHPland
var this_window = window ;
phpEngine.expose(this_window, 'window');

// Expose Window to PHPland
var this_console = console ;
phpEngine.expose(this_console, 'console');

// Expose Window to PHPland
var jsMath = Math ;
phpEngine.expose(jsMath, 'jsMath');

// Write content HTML to the DOM
phpEngine.getStdout().on('data', function (data) {
    document.body.insertAdjacentHTML('beforeEnd', data);
});

// this is looking in the filedata file which is all the php compressed in a key value with path keys
var php_code_string = '<?php '+file_require_string+' ?>' ;

// Go!
phpEngine.execute(php_code_string).fail(function (error) {
    console.warn('ERROR: ' + error.toString());
});
