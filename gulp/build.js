var gulp = require('gulp');
var env = require('gulp-env');

env.isProduction = false;

gulp.task('build:fe', ['sass:fe', 'js-vendors', 'eslint', 'js-app', 'images', 'fonts', 'jsons']);
gulp.task('build:be', ['sass:be', 'js:be', 'flowjs', 'sortable', 'images']);
gulp.task('build', ['build:fe', 'build:be']);
