const gulp = require( 'gulp' );
const gulpif = require( 'gulp-if' );
const gzip = require( 'gulp-gzip' );
const sourcemaps = require( 'gulp-sourcemaps' );
const terser = require( 'gulp-terser' );

const config = require( '../config' );

function scripts( cb ) {
  gulp.src( 'src/scripts/**/*.js' )
    .pipe( gulpif( config.sourcemaps, sourcemaps.init({ loadMaps: true }) ) )
    .pipe( gulpif( config.uglify, terser() ) )
    .pipe( gulpif( config.sourcemaps, sourcemaps.write( './' ) ) )
    .pipe( gulp.dest( config.dest + '/scripts' ) )
    .pipe( gulpif( config.gzip, gzip() ) )
    .pipe( gulpif( config.gzip, gulp.dest( config.dest + '/scripts' ) ) );

  cb();
}

exports.default = scripts;