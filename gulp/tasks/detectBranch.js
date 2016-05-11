var gulp = require('gulp');
var git = require('gulp-git');
var env = require('gulp-env');
var config = require('../config');

gulp.task('is-production', function (cb) {
    git.revParse({
        args: '--abbrev-ref HEAD'
    }, function (err, currentBranch) {
        env({
            vars: {
                IS_PRODUCTION_BRANCH: currentBranch === config.git.productionBranch ? 1 : 0
            }
        });
        cb(err);
    });
});
