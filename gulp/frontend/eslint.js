var gulp            = require('gulp');
var config          = require('../config.frontend').js;
var eslint          = require('gulp-eslint');


gulp.task('eslint', function() {
    return gulp.src(config.src)
        .pipe(eslint())
        .pipe(eslint.format());
});
