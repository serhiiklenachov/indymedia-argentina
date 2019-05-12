const argv = require( 'yargs' ).argv;

const env = argv.env || 'development';

try {
  config = require( `./${ env }` );
  config.environment = env;
} catch ( e ) {
  throw new Error( `No config file found for environment ${ env }` );
}

module.exports = config;