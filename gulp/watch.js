var gulp = require('gulp');
var batch = require('gulp-batch');
var config = require('./config');


gulp.task('watch:fe', ['build:fe'], function () {
    gulp.watch(config.frontend.sass.src, batch(function (events, done) {
        gulp.start('sass:fe', done);
    }));
    gulp.watch(config.frontend.js.src, batch(function (events, done) {
        gulp.start('js-app', ['eslint'], done);
    }));
    gulp.watch(config.frontend.images.src, batch(function (events, done) {
        gulp.start('images', done);
    }));
    gulp.watch(config.frontend.fonts.src, batch(function (events, done) {
        gulp.start('fonts', done);
    }));
    gulp.watch(config.frontend.jsons.src, batch(function (events, done) {
        gulp.start('jsons', done);
    }));
});

gulp.task('watch:be', ['build:be'], function () {
    gulp.watch(config.backend.js.adminSrc, batch(function (events, done) {
        gulp.start('js:be', done);
    }));
    gulp.watch(config.frontend.images.src, batch(function (events, done) {
        gulp.start('images', done);
    }));
    gulp.watch(config.backend.sass, batch(function (events, done) {
        gulp.start('sass:be', done);
    }));
});
