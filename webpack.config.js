var Encore = require('@symfony/webpack-encore');

Encore
// directory where compiled assets will be stored
    .setOutputPath('web/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Add 1 entry for each "page" of your app
     * (including one that's included on every page - e.g. "app")
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if you JavaScript imports CSS.
     */
    .addEntry(
        'js/library', [
            './node_modules/jquery/dist/jquery.min.js',
            './node_modules/popper.js/dist/popper.min.js',
            './node_modules/bootstrap/dist/js/bootstrap.min.js',
            './node_modules/bootstrap/dist/js/bootstrap.bundle.min.js'
        ]
    )
    .addEntry('js/app', './assets/js/app.js')
    .addStyleEntry(
        'css/library', [
            './node_modules/bootstrap/dist/css/bootstrap-reboot.min.css',
            './node_modules/bootstrap/dist/css/bootstrap.min.css',
            './node_modules/bootstrap/dist/css/bootstrap-grid.min.css'
        ]
    )
    .addStyleEntry('css/app', './assets/css/app.css')

    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())
// uncomment if you use TypeScript
//.enableTypeScriptLoader()

// uncomment if you use Sass/SCSS files
//.enableSassLoader()

// uncomment if you're having problems with a jQuery plugin
.autoProvidejQuery()
.autoProvideVariables({
    'window.jQuery': 'jquery'
})
;

module.exports = Encore.getWebpackConfig();