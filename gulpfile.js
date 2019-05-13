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

exports.watch = () => {
  gulp.watch( 'src/fonts/**/*', fonts );
  gulp.watch( 'src/images/screenshot.{png,jpg,jpeg}', imagesScreenshot );
  gulp.watch([
    'src/images/**/*',
    '!src/images/screenshot.{png,jpg,jpeg}'
  ], imagesOthers );
  gulp.watch( 'src/scripts/**/*.js', gulp.series( linter, scripts ) );
  gulp.watch( 'src/styles/style.scss', stylesMain );
  gulp.watch([
    'src/styles/*.scss',
    '!src/styles/style.scss'
  ], stylesOthers );
  gulp.watch( 'src/styles/*.css', stylesDirect );
  gulp.watch( 'src/templates/**/*.php', templates );
  gulp.watch( 'src/vendor/**/*', vendor );
}
