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

gulp.task('css', function() {

    gulp.src('./public/css/styles.css')
        .pipe(cssnano({zindex: false}))
        .pipe(rename(applicationCss))
        .pipe(gulp.dest('./public/css/'));
});

// Default Task
gulp.task('default', ['css']);