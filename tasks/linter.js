const gulp = require( 'gulp' );
const eslint = require( 'gulp-eslint' );

function linter( cb ) {
  gulp.src( 'src/scripts/**/*.js' )
    .pipe( eslint({
      baseConfig: {
        'parserOptions': {
          'ecmaVersion': 6,
          'sourceType': 'module',
          'ecmaFeatures': {
            'jsx': true,
            'modules': true,
            'experimentalObjectRestSpread': true
          }
        }
      }
    }) )
    .pipe( eslint.format() )
    .pipe( eslint.failAfterError() );

  cb();
}

exports.default = linter;