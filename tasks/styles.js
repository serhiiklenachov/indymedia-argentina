const autoprefixer = require( 'gulp-autoprefixer' );
const cleancss = require( 'gulp-clean-css' );
const gulp = require( 'gulp' );
const gulpif = require( 'gulp-if' );
const gzip = require( 'gulp-gzip' );
const plumber = require( 'gulp-plumber' );
const sass = require( 'gulp-sass' );
const sourcemaps = require( 'gulp-sourcemaps' );

const config = require( '../config' );

function main( cb ) {
  gulp.src( 'src/styles/style.scss' )
    .pipe( plumber() )
    .pipe( gulpif( config.sourcemaps, sourcemaps.init() ) )
    .pipe( sass( config.sass ) )
    .pipe( autoprefixer( config.autoprefixer ) )
    .pipe( gulpif( config.cleancss, cleancss() ) )
    .pipe( gulpif( config.sourcemaps, sourcemaps.write( '.' ) ) )
    .pipe( gulp.dest( config.dest ) )
    .pipe( gulpif( config.gzip, gzip() ) )
    .pipe( gulpif( config.gzip, gulp.dest( config.dest ) ) );

  cb();
}

function others( cb ) {
  gulp.src([
    'src/styles/*.scss',
    '!src/styles/style.scss'
  ], { allowEmpty: true })
    .pipe( plumber() )
    .pipe( gulpif( config.sourcemaps, sourcemaps.init() ) )
    .pipe( sass( config.sass ) )
    .pipe( autoprefixer( config.autoprefixer ) )
    .pipe( gulpif( config.cleancss, cleancss() ) )
    .pipe( gulpif( config.sourcemaps, sourcemaps.write( '.' ) ) )
    .pipe( gulp.dest( config.dest + '/styles' ) )
    .pipe( gulpif( config.gzip, gzip() ) )
    .pipe( gulpif( config.gzip, gulp.dest( config.dest + '/styles' ) ) );
  cb();
}

function direct( cb ) {
  gulp.src( 'src/styles/*.css', { allowEmpty: true } )
    .pipe( gulp.dest( config.dest + '/styles' ) )
    .pipe( gulpif( config.gzip, gzip() ) )
    .pipe( gulpif( config.gzip, gulp.dest( config.dest + '/styles' ) ) );

  cb();
}

exports.main = main;
exports.others = others;
exports.direct = direct;
exports.default = gulp.parallel(main, others, direct);