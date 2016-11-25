var gulp = require('gulp');
var size = require('gulp-filesize');
var gulpif = require('gulp-if');
var notify = require('gulp-notify');
var sass = require('gulp-sass');
var sourcemaps = require('gulp-sourcemaps');
var handleErrors = require('../util/handleErrors');
var config = require('../config.frontend').sass;
var env = require('gulp-env');

function handleCSSError(err) {
    notify().write('\nERROR IN SASS ---------------\n' + err.message + '\n /ERROR ---------------');
    this.emit('end');
}

gulp.task('sass:fe', function () {
    var isProduction = env.isProduction;

    return gulp.src(config.src)
        .pipe(gulpif(!isProduction, sourcemaps.init()))
        .pipe(gulpif(isProduction, sass(config.prodSettings), sass(config.devSettings)))
        .on('error', handleErrors)
        .pipe(gulpif(!isProduction, sourcemaps.write()))
        .pipe(gulp.dest(config.dest))
        .pipe(size());
});
