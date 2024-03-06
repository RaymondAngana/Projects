'use strict';

import gulp from 'gulp';
import autoprefixer from 'gulp-autoprefixer';
import sass from 'gulp-sass';
import hash from 'gulp-hash';

import gulpPostcss from 'gulp-postcss';
import cssDeclarationSorter from 'css-declaration-sorter';

import sourcemaps from 'gulp-sourcemaps';
import csso from 'gulp-csso';
// import cleanCSS from 'gulp-clean-css';
import gutil from 'gulp-util';
import gcmq from 'gulp-group-css-media-queries';
import hashOptions from './hash';

const paths = global.paths;

const prepareDistCss = () => {
  const dest = paths.dist + '/styles/';
  gulp.src(paths.dev.sass + '*.scss')
    .pipe(sass()).on('error', function(error) {
      gutil.log(error.toString());
      this.emit('end');
    })
    .pipe(autoprefixer({
      browsers: ['last 2 versions', 'safari >= 10', 'ie >= 11', '> 1%'],
      cascade: false
    }))
    .pipe(gulpPostcss([cssDeclarationSorter({order: 'alphabetically'})]))
    .pipe(csso())
    // .pipe(rename({
    //     suffix: '.min'
    // }))
    .pipe(hash(hashOptions))
    .pipe(gulp.dest(dest))
    .pipe(hash.manifest('dist/assets.json'), {
      deleteOld: true,
      sourceDir: dest
    })
    .pipe(gulp.dest('.'));
      
  // return gulp.src(paths.dev.cssVend + '/**/*', {
  //       dot: true})
  //     .pipe(gulpPostcss([cssDeclarationSorter({order: 'alphabetically'})]))
  //     .pipe(cssNano({
  //       autoprefixer: {browsers: ['last 2 versions', 'safari >= 10', 'ie >= 11', '> 1%']},
  //       reduceIdents: true,
  //       zindex: false
  //     }))
  //     .pipe(gulp.dest(paths.dist + '/styles'));
};

// copy CSS files from dev to src/styles
gulp.task('vendorCss', () => {
  return gulp.src(
    paths.dev.cssVend + '/**/*', {
      dot: true})
    .pipe(gulp.dest(paths.build.css));
});

// compile SASS with sourcemaps and copy dev CSS
gulp.task('sass', () => {
  return gulp.src(paths.dev.sass + '*.scss')
    .pipe(sourcemaps.init())
    .pipe(sass()).on('error', function(error) {
      gutil.log(error.toString());
      this.emit('end');
    })
    .pipe(autoprefixer({
      browsers: ['last 2 versions', 'safari >= 10', 'ie >= 11', '> 1%'],
      cascade: false
    }))
    .pipe(gcmq())
    // .pipe(gulpPostcss([cssDeclarationSorter({order: 'smacss'})]))
    .pipe(gulpPostcss([cssDeclarationSorter({order: 'alphabetically'})]))
    
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest(paths.build.css));
});

// compile SASS (excludes sourcemaps)
gulp.task('sass_dist', () => {
    // prepareDevCss();

    return prepareDistCss();
});
