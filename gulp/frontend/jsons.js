var gulp = require('gulp');
var changed = require('gulp-changed');
var size = require('gulp-filesize');
var config = require('../config.frontend').jsons;


gulp.task('jsons', function () {

    return gulp.src(config.src)
        .pipe(changed(config.dest)) // Ignore unchanged files
        .pipe(gulp.dest(config.dest))
        .pipe(size());
});
