var gulp = require('gulp');
var env = require('gulp-env');

env.isProduction = false;

gulp.task('build', ['admin', 'sass', 'js-vendors', 'js-app', 'js-admin', 'flowjs', 'sortable', 'images', 'fonts', 'jsons']);
