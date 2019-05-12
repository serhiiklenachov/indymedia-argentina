const del = require( 'del' );
const config = require( '../config' );

function clean() {
  return del([
    config.dest + '/**',
    '!' + config.dest,
    '!' + config.dest + '/vendor/**'
  ]);
}

exports.default = clean;