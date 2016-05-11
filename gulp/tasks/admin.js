var gulp = require('gulp');
var size = require('gulp-filesize');
var concat = require('gulp-concat');
var config = require('../config').admin;

gulp.task('admin', function () {
    return gulp.src(config.src)
        .pipe(concat('admin.css'))
        .pipe(gulp.dest(config.dest))
        .pipe(size());
});
