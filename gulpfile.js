const gulp = require( 'gulp' );

const clean = require( './tasks/clean' ).default;

const fonts = require( './tasks/fonts' ).default;

const images = require( './tasks/images' ).default;
const imagesScreenshot = require( './tasks/images' ).screenshot;
const imagesOthers  = require( './tasks/images' ).others;

const linter = require( './tasks/linter' ).default;

const scripts = require( './tasks/scripts' ).default;

const styles = require( './tasks/styles' ).default;
const stylesMain = require( './tasks/styles' ).main;
const stylesOthers = require( './tasks/styles' ).others;
const stylesDirect = require( './tasks/styles' ).direct;

const templates = require( './tasks/templates' ).default;

const vendor = require( './tasks/vendor' ).default;

exports.vendor = vendor;

exports.build = gulp.series(
  linter,
  clean,
  gulp.parallel(
    fonts,
    images,
    scripts,
    styles,
    templates
  )
);

function watch() {
  gulp.watch(
    
  )
}

exports.watch = watch;