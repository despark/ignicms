var gulp = require('gulp');
var env = require('gulp-env');

env.isProduction = false;

gulp.task('dev:fe', ['build:fe']);
gulp.task('dev:be', ['build:be']);
gulp.task('dev', ['build:fe', 'build:be']);
