var gulp = require('gulp');
var env = require('gulp-env');

// Run this to compress all the things!
gulp.task('production', function () {
    env.isProduction = true;
    gulp.start(['build:fe', 'build:be']);
});
