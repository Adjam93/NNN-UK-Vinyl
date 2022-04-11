/**
 * External Dependencies
 */
const path = require( 'path' );

/**
 * WordPress Dependencies
 */
const defaultConfig = require( '@wordpress/scripts/config/webpack.config.js' );

const jsPath= './assets/js';
const outputPath = 'dist';
const entryPoints = {
  // you can have more than 1 entry point
  'main': jsPath + '/main.js',
};

 module.exports = {
     ...defaultConfig,
     ...{
         // Add any overrides to the default here.
        entry: entryPoints,
        output: {
          path: path.resolve(__dirname, outputPath),
          filename: 'bundled.js',
        },
     }
}