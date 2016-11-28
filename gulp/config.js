var dest = './public';
var src = './resources/assets';
var vendors = './vendor/bower_components';
var neat = require('node-neat').includePaths;
var bourbon = require('node-bourbon').includePaths;
var frontend = require('./config.frontend');
var backend = require('./config.backend');

module.exports = {
    frontend: frontend,
    backend: backend
}
