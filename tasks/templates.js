const gulp = require( 'gulp' );
const config = require( '../config' );

function templates( cb ) {
  gulp.src( 'src/templates/**/*.php' )
    .pipe( gulp.dest( config.dest ) );

  cb();
};

exports.default = templates;