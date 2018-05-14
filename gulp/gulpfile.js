// Set directories
var src = '../';
var projectPath = 'dbexam';

// Requires
var gulp = require('gulp');
var sass = require('gulp-sass');
var browserSync = require('browser-sync').create();
var gulpIf = require('gulp-if');
var runSequence = require('run-sequence');
var autoprefixer = require('gulp-autoprefixer');
var plumber = require('gulp-plumber');

gulp.task('sass', function(){
    return gulp.src(src+'/scss/main.scss')
        .pipe(plumber())
        .pipe(sass())
        .pipe(autoprefixer({
            browsers: ['last 5 versions'],
            cascade: false
        }))
        .pipe(gulp.dest(src))
        .pipe(browserSync.reload({
            stream: true
        }))
});

gulp.task('browserSync', function () {
    browserSync.init({
        proxy: "localhost/"+projectPath
    })
});

// Watch task
gulp.task('watch', ['browserSync', 'sass'], function(){
    gulp.watch(src+'/scss/**.scss', ['sass']);
    // Reload when html or js files change
    gulp.watch(src+'**.js', browserSync.reload);
    gulp.watch(src+'**/*.php', browserSync.reload);
});

// Default, runs on gulp command
gulp.task('default', function (callback) {
    runSequence(['sass', 'browserSync', 'watch'],
    callback)
})