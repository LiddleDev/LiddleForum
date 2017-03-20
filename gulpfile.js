'use strict';

var gulp = require('gulp'),
    del = require('del'),
    concat = require('gulp-concat'),
    rename = require('gulp-rename'),
    cssnano = require('gulp-cssnano'),
    uglify = require('gulp-uglify'),
    less = require('gulp-less');

// Minified names
var applicationCss = 'styles.min.css';

// LESS Backend
gulp.task('less', function() {

    // Frontend
    return gulp.src('./web/assets/backend/less/styles.less')
        .pipe(concat('compiled.less'))
        .pipe(less())
        .pipe(rename('compiled.css'))
        .pipe(gulp.dest('./web/assets/backend/css'));

});

// Backend Tasks
gulp.task('css', ['less'], function() {

    gulp.src('./web/assets/backend/css/compiled.css')
        .pipe(cssnano({zindex: false}))
        .pipe(rename(applicationCss))
        .pipe(gulp.dest('./web/assets/backend/css'));
});

// Default Task
gulp.task('default', ['css']);