'use strict';

import gulp from 'gulp';
import del from 'del';

const paths = global.paths;

// clean the build dir
gulp.task('clean', () => {
  del([`${paths.dist}/*`]);
});

gulp.task('clean_dist', () => {
  del([`${paths.dist}/styles/*.css`]);
  del([`${paths.dist}/scripts/*.js`]);
});
