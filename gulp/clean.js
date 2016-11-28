var gulp = require('gulp');
var rimraf = require('gulp-rimraf');
var config = require('./config').frontend;

// Cleans up front-end stuff from public folder
gulp.task('clean', function () {
    return gulp.src([
            config.sass.dest,
            config.js.dest,
            config.images.dest,
            config.fonts.dest
        ], {
            read: false
        })
        .pipe(rimraf());
});
