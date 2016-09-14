var gulp = require('gulp');
var config = require('../config').sortable;

gulp.task('sortable', function () {

    return gulp.src(config.src).pipe(gulp.dest(config.dest));
});
