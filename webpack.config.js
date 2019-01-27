const Encore = require('@symfony/webpack-encore');
const WebpackCleanupPlugin = require('webpack-cleanup-plugin');
const OptimizeCssAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const WebpackNotifierPlugin = require('webpack-notifier');


Encore
  .enableSingleRuntimeChunk()
  .setOutputPath('public/dist/')
  .setPublicPath('/dist')
  .addEntry('app', ['./assets/js/main.js'])
  .addStyleEntry('style', './assets/scss/style.scss')
  // .enableReactPreset()
  .enableVersioning()
  .configureFilenames({
    css: 'css/[name].[contenthash].css',
    js: 'js/[name].[contenthash].js',
    images: 'images/[name].[hash:8].[ext]'
  })
  .enableSassLoader()
  .enableSourceMaps(!Encore.isProduction())
    .addPlugin(new WebpackCleanupPlugin(
        {
            output: {
                preview: true,
                path: "public/dist"
            }
        }
    ));

if(Encore.isDev()){
    Encore.addPlugin(new WebpackNotifierPlugin())
}

if (Encore.isProduction()) {
  Encore
    .addPlugin(new OptimizeCssAssetsPlugin({
      cssProcessorOptions: {
        discardComments: {
          removeAll: true
        }
      }
    }))
};

module.exports = Encore.getWebpackConfig();
