var gulp = require('gulp');
var env = require('gulp-env');

env.isProduction = false;
gulp.task('default', ['admin', 'sass', 'js-vendors', 'js-app', 'js-admin', 'js-plupload', 'images', 'fonts', 'jsons', 'watch']);
