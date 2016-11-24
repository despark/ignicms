var gulp = require('gulp');
var env = require('gulp-env');

env.isProduction = false;
gulp.task('default:fe', ['build:fe', 'watch']);
gulp.task('default:be', ['build:be', 'watch']);
