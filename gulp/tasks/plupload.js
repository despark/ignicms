var gulp = require('gulp');
var uglify = require('gulp-uglify');
var notify = require('gulp-notify');
var size = require('gulp-filesize');
var cncat = require('gulp-concat');
var jshint = require('gulp-jshint');
var config = require('../config').plupload;
var env = require('gulp-env');

gulp.task('js-plupload', function () {
    var isProduction = env.isProduction;
    return gulp.src(config.src).pipe(gulp.dest(config.dest));
});
