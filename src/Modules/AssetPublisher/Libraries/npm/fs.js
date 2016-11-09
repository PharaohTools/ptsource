/*
 * Demo of packaging PHP files up with Browserify+Uniter
 *
 * MIT license.
 */
'use strict';


var fs = require('fs'),
    globby = require('globby'),
    path = require('path'),
    files = globby.sync([
        __dirname + '/../../../**/Assets/php/*.phpfe'
    ]),
    main_files = globby.sync([
        __dirname + '/../../../**/Assets/php/main.phpfe'
    ]),
    fileData = {},
    root = __dirname + '/..';

files.forEach(function (filePath) {
    fileData[path.relative(root, filePath)] = fs.readFileSync(filePath).toString();
});

fs.writeFileSync(
    __dirname + '/../../../PostInput/Assets/Modules/DefaultSkin/js/fileData.js',
    'module.exports = ' + JSON.stringify(fileData) + ';'
);

//fs.writeFileSync(
//    __dirname + '/../../../DefaultSkin/Assets/js/fileData.js',
//    'module.exports = ' + JSON.stringify(fileData) + ';'
//);

fs.writeFileSync(
    __dirname + '/../../../DefaultSkin/Assets/js/mainFiles.js',
    'module.exports = ' + JSON.stringify(main_files) + ';'
);

fs.writeFileSync(
    __dirname + '/../../../PostInput/Assets/Modules/DefaultSkin/js/mainFiles.js',
    'module.exports = ' + JSON.stringify(main_files) + ';'
);