var gulp = require('gulp');
var batch = require('gulp-batch');
var config = require('../config');


gulp.task('watch:fe', ['build:fe'], function () {
    gulp.watch(config.frontend.sass.src, batch(function (events, done) {
        gulp.start('sass', done);
    }));
    gulp.watch(config.frontend.js.src, batch(function (events, done) {
        gulp.start('js-app', done);
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
    gulp.watch(config.frontend.admin.sass, batch(function (events, done) {
        gulp.start('admin', done);
    }));
});

gulp.task('watch:be', ['build:be'], function () {
    gulp.watch(config.backend.js.src, batch(function (events, done) {
        gulp.start('js-admin', done);
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
    gulp.watch(config.backend.sass, batch(function (events, done) {
        gulp.start('admin', done);
    }));
});
