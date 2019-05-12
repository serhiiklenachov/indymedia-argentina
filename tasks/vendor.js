const gulp = require( 'gulp' );
const del = require( 'del' );
const config = require( '../config' );

function copy( cb ) {
  gulp.src( 'src/vendor/**/*' )
    .pipe( gulp.dest( config.dest + '/vendor' ) );

  cb();
};

function clean() {
  return del( config.dest + '/vendor' );
}

exports.default = gulp.series(clean, copy);