var gulp = require('gulp');
var config = require('../config.backend').flowjs;

gulp.task('flowjs', function () {
    return gulp.src(config.src).pipe(gulp.dest(config.dest));
});
