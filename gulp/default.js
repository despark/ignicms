var gulp = require('gulp');
var env = require('gulp-env');

env.isProduction = false;
gulp.task('default:fe', ['build:fe', 'watch:fe']);
gulp.task('default:be', ['build:be', 'watch:be']);
