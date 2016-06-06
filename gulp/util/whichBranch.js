/* whichBranch
   ------------
   Detects current Git branch
*/

var gulp = require('gulp');
var git = require('gulp-git');
var config = require('../config');

module.exports = {
    isProduction: function () {
        git.revParse({
            args: '--abbrev-ref HEAD'
        }, function (err, currentBranch) {
            if (err) throw err;
            console.log('config: ', config.git, ' currentBranch: ', currentBranch);
            console.log('isProd: ', currentBranch ? true : false);
            return config.git.productionBranch === currentBranch ? true : false;
        });
    }
};
