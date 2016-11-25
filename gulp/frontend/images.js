var changed = require('gulp-changed');
var gulp = require('gulp');
var size = require('gulp-filesize');
var imagemin = require('gulp-imagemin');
var config = require('../config.frontend').images;
var gulpif = require('gulp-if');
var env = require('gulp-env');

gulp.task('images', function () {
    var isProduction = env.isProduction;

    return gulp.src([config.src, '!/**/*.db'])
        .pipe(gulpif(!isProduction, changed(config.dest)))
        .pipe(imagemin({
            optimizationLevel: 5,
            progressive: true,
            interlaced: true,
            pngquant: true,
        }))
        .pipe(gulp.dest(config.dest))
        .pipe(size());
});
