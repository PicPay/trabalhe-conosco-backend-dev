var Encore = require('@symfony/webpack-encore');

Encore
// the project directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    .addEntry('app', './assets/js/app.js')
    // .addStyleEntry('style', './assets/css/app.scss')
    // .enableSassLoader()
    .enableVueLoader()
;

module.exports = Encore.getWebpackConfig();
