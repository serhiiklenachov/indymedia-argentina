const gulp = require( 'gulp' );
const config = require( '../config' );

function fonts( cb ) {
  gulp.src( 'src/fonts/**/*' )
    .pipe( gulp.dest( config.dest + '/fonts' ) );

  cb();
};

exports.default = fonts;