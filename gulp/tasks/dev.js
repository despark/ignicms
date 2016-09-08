var gulp = require('gulp');
var env = require('gulp-env');

env.isProduction = false;
gulp.task('dev', ['admin', 'sass', 'js-vendors', 'js-app', 'js-admin', 'js-plupload', 'images', 'fonts', 'jsons']);
