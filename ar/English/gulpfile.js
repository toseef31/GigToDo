'use strict';
var gulp = require('gulp');
var sass = require('gulp-sass');
var autoprefixer = require('autoprefixer');
var postcss = require('gulp-postcss');
var paths = {
    styles: {
        src: 'assets/scss/**/*.scss',
        dest: 'assets/css'
    }
}
function scss() {
    return gulp.src(paths.styles.src)
        .pipe(sass().on('error', sass.logError))
        .pipe(sass({ outputStyle: 'compressed' }))
        .pipe(postcss([autoprefixer()]))
        .pipe(gulp.dest(paths.styles.dest));
}
exports.scss = scss
function watch() {

    scss()

    gulp.watch(paths.styles.src, scss);
}
exports.watch = watch