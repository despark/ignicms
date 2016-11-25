var concat          = require('gulp-concat');
var gulp            = require('gulp');
var uglify          = require('gulp-uglify');
var notify          = require('gulp-notify');
var sourcemaps      = require('gulp-sourcemaps');
var size            = require('gulp-filesize');
var gulpif          = require('gulp-if');
var config          = require('../config.frontend').js;
var env             = require('gulp-env');
var babelify        = require('babelify');
var browserify      = require('browserify');
var source          = require('vinyl-source-stream');
var streamify       = require('gulp-streamify');
var buffer          = require('vinyl-buffer');
var gutil           = require('gulp-util');


var handleErrors = function () {
    const args = Array.prototype.slice.call(arguments);
    notify.onError({
        title: 'Compile Error',
        message: '<%= error.message %>'
    }).apply(this, args);
    console.log(args)
    return this.emit('end');
};

gulp.task('js-app', function() {
    var isProduction = env.isProduction;

    return browserify({
        entries: [config.fileSrc],
        debug: !isProduction
    })
    .transform(babelify.configure({
        sourceMaps: true,
        ignore: '/node_modules/'
    }))
    .bundle()
    .on('error', handleErrors)
    .pipe(source('script.js'))
    .pipe(gulpif(!isProduction, buffer()))
    .pipe(gulpif(!isProduction, sourcemaps.init({ loadMaps: true })))
    .pipe(gulpif(!isProduction, sourcemaps.write('./')))
    .pipe(gulpif(isProduction, streamify(uglify({
        drop_debugger: true,
        mangle: {
            props: true,
            toplevel: true,
            eval: true
        }
    }))))
    .pipe(gulp.dest(config.dest));
});
