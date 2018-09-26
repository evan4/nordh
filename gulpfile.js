"use strict";

var gulp = require('gulp'),
    sass = require('gulp-sass'),
    plumber = require('gulp-plumber'),
    uglify  = require('gulp-uglify'),
    autoprefixer = require('gulp-autoprefixer'),
    sourcemaps = require('gulp-sourcemaps'),
	browserSync = require('browser-sync');

gulp.task('scss', function () {
    gulp.src('dev/scss/style.scss')
        .pipe(sourcemaps.init())
        .pipe(plumber())
        .pipe(sass({
            includePaths: ['dev/scss/style.scss'],
            outputStyle: 'expanded',
            sourceMap: true,
            errLogToConsole: true
        }))
        .pipe(autoprefixer({
            browsers: ['last 3 versions'],
            cascade: false,
            map: true
        }))
        .pipe(sourcemaps.write('./maps'))
        .pipe(gulp.dest('./oc-content/themes/realestate/css'))
        .pipe(browserSync.reload({stream: true}))
});
gulp.task('script', function() {
    return gulp.src([
        'dev/js/**/*.js'
    ])
        //.pipe(uglify())
        .pipe(gulp.dest('./oc-content/themes/realestate/js'))
        .pipe(browserSync.reload({stream: true}));
});
gulp.task('browser-sync', function() { // Создаем таск browser-sync
    browserSync({ // Выполняем browser Sync
        proxy: {
            target: "http://nord/"
        },
        notify: false // Отключаем уведомления
    });
});

gulp.task('watch', [ 'browser-sync', 'script', 'scss'], function() {
    gulp.watch('dev/js/**/*.js', ['script']);
    gulp.watch('dev/scss/**/*.scss', ['scss']);
});

gulp.task('default', function () {
    gulp.start('watch');
});
