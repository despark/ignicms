var gulp = require('gulp');
var env = require('gulp-env');

env.isProduction = false;

gulp.task('build:fe', ['sass', 'js-vendors', 'js-app', 'images', 'fonts', 'jsons']);

gulp.task('build:be', ['admin', 'js-admin', 'flowjs', 'sortable', 'images', 'fonts', 'jsons']);
