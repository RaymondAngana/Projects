'use strict';

import gulp from 'gulp';
import concat from 'gulp-concat';
import uglify from 'gulp-uglify';
import browserify from 'browserify';
import source from 'vinyl-source-stream';
import buffer from 'vinyl-buffer';
import gutil from 'gulp-util';
import sourcemaps from 'gulp-sourcemaps';
import hash from 'gulp-hash';
import es from 'event-stream';
import hashOptions from './hash';

const paths = global.paths;

const nameFiles = global.nameFiles;

const bundleThis = function() {
  // map them to our stream function
  let tasks = nameFiles.map(function(entry) {
      return browserify({
        entries: [paths.dev.js + entry]
      })
      .transform('babelify', {
        presets: ['es2015']
      })
      .bundle().on('error', function(error) {
        gutil.log(error.toString());
        this.emit('end');
      })
      .pipe(source(entry))
      // rename them to have "bundle as postfix"
      .pipe(buffer())
      .pipe(sourcemaps.init())
      .pipe(concat(entry))
      .pipe(uglify())
      .pipe(sourcemaps.write('./'))
      .pipe(gulp.dest(paths.build.js));
  });

  // create a merged stream
  return es.merge.apply(null, tasks);
};

/**
 * Update static scripts
 * @param isDist - bool; true: create dist
 * @return {*}
 */
const updateScripts = function(isDist) {
  let dist;
  let prod;

  prod = gulp.src(paths.dev.jsVend + '**/*')
    .pipe(gulp.dest(paths.build.js));

  if (isDist) {
    dist = gulp.src(paths.dev.jsVend + '**/*')
      .pipe(uglify())
      .pipe(gulp.dest(paths.dist + '/scripts'));

    return es.merge([dist, prod]);
  } else {
    return prod;
  }
};

const buildScripts = function() {
  const dest = paths.dist + '/scripts/';
  // map them to our stream function
  let tasks = nameFiles.map(function(entry) {
      return browserify({
        entries: [paths.dev.js + entry]
      })
      .transform('babelify', {
        presets: ['es2015']
      })
      .bundle().on('error', function(error) {
        gutil.log(error.toString());
        this.emit('end');
      })
      .pipe(source(entry))
      .pipe(buffer())
      .pipe(concat(entry))
      .pipe(uglify())
      .pipe(hash(hashOptions))
      .pipe(gulp.dest(dest))
      .pipe(hash.manifest('dist/assets.json'), {
        deleteOld: true,
        sourceDir: dest
      })
      .pipe(gulp.dest('.'));
  });

  // create a merged stream
  return es.merge.apply(null, tasks);
};

// babelify JavaScript files
gulp.task('scripts', () => {
  updateScripts(false);

  return bundleThis();
});

// babelify and minify JavaScript files (excludes source maps)
gulp.task('scripts_dist', () => {
  updateScripts(true);
  return buildScripts();
});
