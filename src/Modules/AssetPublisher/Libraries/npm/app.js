/*
 * Demo of UI interaction with jQuery+Uniter
 *
 * MIT license.
 */
'use strict';

var $ = jQuery,
    // php = require('phpjs'),
    mainFiles = require('../../../PostInput/Assets/Modules/DefaultSkin/js/mainFiles.js'),
    hasOwn = {}.hasOwnProperty,
    uniter = require('uniter'),
    phpEngine = uniter.createEngine('PHP'),
    output = document.getElementById('output');

var file_require_string = "" ;
var current_page_module = getParameterByName('Control') ;
// mainFiles.forEach(function (filePath) {
//     console.log("current page:  " + current_page_module) ;
//     console.log("this first path: " + filePath) ;
//     var modName = filePath.replace("/opt/ptsource/ptsource/src/Modules/", "");
//     modName = modName.replace("/php/main.phpfe", "");
//     var relative_url = '/Assets/Modules/'+modName+'/php/main.phpfe' ;
//     console.log("this second path: " + filePath) ;
//     console.log("relative url: " + relative_url) ;
//     file_require_string += 'require("'+relative_url+'") ; ';
// });

file_require_string = 'require("/Assets/Modules/DefaultSkin/php/main.phpfe") ; ';

console.log("file_require_string: " + file_require_string) ;

function getParameterByName(name, url) {
    if (!url) {
        url = window.location.href;
    }
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

function getFileData(path) {
    // if (!hasOwn.call(fileData, path)) {
    //     throw new Error('Unknown file "' + path + '"');
    // }
    console.log("trying to load: ", path) ;
    var filedata ;
    $.ajax({
        url: path,
        dataType: 'text',
        async: false,
        success: function (data, textStatus, jqXHR) {
            filedata = jqXHR.responseText ;
        },
        failure: function (data, textStatus, jqXHR) {
            filedata = jqXHR.responseText ;
        },
    });
    return filedata;
}

// Set up a PHP module loader
phpEngine.configure({
    include: function (path, promise) {
        var fd = getFileData(path) ;
        console.log("fd: " + fd) ;
        promise.resolve(fd);
    }
});

var php = "" ;
// Expose jQuery to PHPland
phpEngine.expose($, 'jQuery');
phpEngine.expose(php, 'phpjs');

// Expose Window to PHPland
var this_window = window ;
phpEngine.expose(this_window, 'window');

// Expose Window to PHPland
var this_console = console ;
phpEngine.expose(this_console, 'console');

// Expose Window to PHPland
// var jsMath = Math ;
// phpEngine.expose(jsMath, 'jsMath');

// Write content HTML to the DOM
phpEngine.getStdout().on('data', function (data) {
    document.body.insertAdjacentHTML('beforeEnd', data);
});

// this is looking in the filedata file which is all the php compressed in a key value with path keys
var php_code_string = '<?php '+file_require_string+' ?>' ;

// Go!
phpEngine.execute(php_code_string).fail(function (error) {
    // console.warn('ERROR: ' + error.toString());
});
