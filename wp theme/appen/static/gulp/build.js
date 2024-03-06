'use strict';

import gulp from 'gulp';
import requireDir from 'require-dir';
import imagemin from 'gulp-imagemin';
import htmlMin from 'gulp-htmlmin';
import pngquant from 'imagemin-pngquant';
import jpgcompress from 'imagemin-jpeg-recompress';
import scgmin from 'imagemin-svgo';
// import replace from 'gulp-replace';
import runSeq from 'run-sequence';

const paths = global.paths;

requireDir('../gulp', { recurse: false });

gulp.task('build', (done) => {
    runSeq('clean_dist', ['build_sass', 'build_img', 'build_js'], 'build_html', 'copy', done);
});

// build SASS for distribution
gulp.task('build_sass', ['sass_dist'/*, 'lint_sass'*/]);

// build JS for distribution
gulp.task('build_js', ['scripts_dist'/*, 'lint_js'*/]);

// build HTML for distribution
gulp.task('build_html', () => {
    gulp.src(paths.dev.html + '*.html')
        .pipe(htmlMin({
            removeComments: true,
            collapseWhitespace: true,
            collapseBooleanAttributes: true,
            removeAttributeQuotes: true,
            removeRedundantAttributes: true,
            removeEmptyAttributes: true,
            removeScriptTypeAttributes: true,
            removeStyleLinkTypeAttributes: true,
            removeOptionalTags: true
        }))
        .pipe(gulp.dest(paths.dist));
});

// build images for distribution
gulp.task('build_img', () => {
    gulp.src(paths.build.img + '**/*.*')
        .pipe(imagemin(
            [pngquant(), jpgcompress(), scgmin({removeViewBox: false})],
            {
                progressive: true,
                verbose: true,
                interlaced: true
            }
        ))
        .pipe(gulp.dest(paths.dist + '/images'));
});

// Copy all files at dist
gulp.task('copy', () => {
    gulp.src([
            paths.build.buildPath + '/**/*',
            '!' + paths.build.js,
            '!' + paths.build.js + '**/*',
            '!' + paths.build.css,
            '!' + paths.build.css + '**/*',
            '!' + paths.build.src + '/temp',
            '!' + paths.build.src + '/*.js'
        ], {
            dot: true
        })
        .pipe(gulp.dest(paths.dist));
});
