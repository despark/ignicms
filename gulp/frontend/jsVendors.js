var gulp = require('gulp');
var uglify = require('gulp-uglify');
var size = require('gulp-filesize');
var cncat = require('gulp-concat');
var gulpif = require('gulp-if');
var config = require('../config.frontend');
var env = require('gulp-env');

gulp.task('js-vendors', function () {
    var isProduction = env.isProduction;

    return gulp.src(config.bowerComponents)
        .pipe(cncat('vendors.js'))
        .pipe(gulpif(isProduction, uglify()))
        .pipe(gulp.dest(config.js.dest))
        .pipe(size());
});
