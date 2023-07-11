const gulp = require('gulp');
const concat = require('gulp-concat');
const uglify = require('gulp-uglify');

gulp.task('minify-public-js', function () {
    return gulp.src('public/js/**/*.js')
        .pipe(uglify())
        .pipe(concat('public.min.js'))
        .pipe(gulp.dest('public/build/js'));
});

gulp.task('minify-public-adminlte-js', function () {
    return gulp.src('public/adminlte3/**/*.js')
        .pipe(uglify())
        .pipe(concat('adminlte3.min.js'))
        .pipe(gulp.dest('public/build/js'));
});

gulp.task('default', gulp.series('minify-public-js', 'minify-public-adminlte-js'));