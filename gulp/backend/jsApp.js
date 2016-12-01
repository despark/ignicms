var gulp = require('gulp');
var uglify = require('gulp-uglify');
var notify = require('gulp-notify');
var size = require('gulp-filesize');
var cncat = require('gulp-concat');
var gulpif = require('gulp-if');
var config = require('../config.backend').js;
var env = require('gulp-env');

gulp.task('js:be', function () {
    var isProduction = env.isProduction;

    return gulp.src(config.vendorSrc)
        .pipe(cncat('admin.js'))
        .pipe(gulpif(isProduction, uglify({
            drop_debugger: true,
            mangle: {
                props: true,
                // toplevel: true,
                eval: true
            }
        })))
        .pipe(gulp.dest(config.dest))
        .pipe(size());
});
