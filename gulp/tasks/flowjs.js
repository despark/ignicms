var gulp = require('gulp');
var config = require('../config').flowjs;

gulp.task('flowjs', function () {

    return gulp.src(config.src).pipe(gulp.dest(config.dest));
});
