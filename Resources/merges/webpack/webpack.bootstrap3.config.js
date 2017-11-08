var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('web/assets/')
    .setPublicPath('/assets')
    .cleanupOutputBeforeBuild()
    .createSharedEntry('vendor', ['./assets/js/vendor.js', './assets/css/vendor.scss'])
    .addEntry('app', ['./assets/js/app.js', './assets/css/app.scss'])
    .enableSassLoader()
    .autoProvidejQuery()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
;

module.exports = Encore.getWebpackConfig();