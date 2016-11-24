
var gulp = require('gulp');
var sass = require('gulp-sass');
var merge = require('merge-stream');
var concat = require('gulp-concat');
var rename = require('gulp-rename');
var config = require('../config').backend;

var size = require('gulp-filesize');
var gulpif = require('gulp-if');
var notify = require('gulp-notify');
var sourcemaps = require('gulp-sourcemaps');
var handleErrors = require('../util/handleErrors');
var env = require('gulp-env');

function handleCSSError(err) {
    notify().write('\nERROR IN SASS ---------------\n' + err.message + '\n /ERROR ---------------');
    this.emit('end');
}

//define default task
gulp.task('admin', function () {
    //select additional css files
    var cssStream = gulp.src(config.css);

    var isProduction = env.isProduction;
    //compile sass
    var sassStream = gulp.src(config.sass)
        .pipe(gulpif(!isProduction, sourcemaps.init()))
        .pipe(gulpif(isProduction, sass(config.prodSettings), sass(config.devSettings)))
        .on('error', handleErrors)
        .pipe(gulpif(!isProduction, sourcemaps.write()))
        .pipe(size());

    var merged = merge(cssStream, sassStream);

    return merged
        .pipe(concat('admin.css'))
        .pipe(gulp.dest(config.dest));
});
