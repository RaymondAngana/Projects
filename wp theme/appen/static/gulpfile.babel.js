'use strict';

import gulp from 'gulp';
import requireDir from 'require-dir';

// we define our input files, which we want to have
// bundled:

global.nameFiles = [
  'app.js',
  'blogWithMenu.js',
  'blogWithForm.js',
  'initSliders.js',
  'case-study.js',
  'blog-single.js',
  'resources-filter.js'
];

global.paths = {
  dev: {
    // dev destination folder
    'devPath': './src/dev/',
    // HTML source files
    'html': './src/dev/html/',
    // SASS source files
    'sass': './src/dev/scss/',
    // image sources files
    'img': './src/dev/images/',
    // SVG sources files
    'svg': './src/dev/svg/',
    // JS source files
    'js': './src/dev/js/',
    // Fonts source files
    'fonts': './src/dev/fonts/',
    // Vendor CSS source files
    'cssVend': './src/dev/vendor-css/',
    // Vendor JS source files
    'jsVend': './src/dev/vendor-js/'
  },
  build: {
    // build destination folder
    'buildPath': './src/build/',
    // build CSS folder
    'css': './src/build/styles/',
    // build JS folder
    'js': './src/build/scripts/',
    // Fonts source files
    'fonts': './src/build/fonts/',
    // Images source files
    'img': './src/build/images/'
  },
  // distribution folder
  'dist': './dist'
};

requireDir('./gulp', { recurse: false });

gulp.task('default', ['build']);
