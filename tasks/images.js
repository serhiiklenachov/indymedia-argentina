const gulp = require( 'gulp' );
const gulpif = require( 'gulp-if' );
const imagemin = require( 'gulp-imagemin' );

const config = require( '../config' );

function screenshot( cb ) {
  gulp.src( 'src/images/screenshot.{png,jpg,jpeg}', { allowEmpty: true } )
    .pipe( gulpif( config.imagemin, imagemin({ verbose: config.debug }) ) )
    .pipe( gulp.dest( config.dest ) );

  cb();
}

function others( cb ) {
  gulp.src([
    'src/images/**/*',
    '!src/images/screenshot.{png,jpg,jpeg}'
  ], { allowEmpty: true })
    .pipe( gulpif( config.imagemin, imagemin({ verbose: config.debug }) ) )
    .pipe( gulp.dest( config.dest + '/images' ) );

  cb();
}

exports.screenshot = screenshot;
exports.others = others

exports.default = gulp.parallel(screenshot, others);