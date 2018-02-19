import path from 'path';
import webpack from 'webpack';
import { BundleAnalyzerPlugin } from 'webpack-bundle-analyzer';
import ExtractTextPlugin from 'extract-text-webpack-plugin';

const UglifyJsPlugin = require('uglifyjs-webpack-plugin');

const absPath = dir => path.resolve(__dirname, `../${dir}`);

const CSS_STACK = ({
  scss = true,
  vue = false,
  sassResources = false,
  production = false,
} = {}) => [
  ...(production
    ? []
    : {
        loader: vue ? 'vue-style-loader' : production ? '' : 'style-loader',
      }),
  {
    loader: 'css-loader',
  },
  ...(scss
    ? [
        {
          loader: 'sass-loader',
        },
      ]
    : {}),
  ...(sassResources
    ? [
        {
          loader: 'sass-resoures-loader',
          options: {
            resources: [
              absPath('frontEndSources/scss/_variables.scss'),
              absPath('frontEndSources/scss/_mixins.scss'),
              absPath('frontEndSources/scss/_functions.scss'),
            ],
          },
        },
      ]
    : []),
];

const webpackConfig = env => ({
  devtool: env === 'production' ? 'source-map' : 'cheap-eval-source-map',
  entry: {
    app: absPath('frontEndSources/CraftGonzo.js'),
  },
  output: {
    path: absPath('src/assetbundles/gonzo/dist/'),
    publicPath: 'http://localhost:8080/',
    filename: 'js/CraftGonzo.js',
    chunkFilename: 'js/[id].js',
  },
  devServer: {
    contentBase: absPath('resources/'),
    publicPath: 'http://localhost:8080/',
    hotOnly: true,
    inline: true,
    overlay: true,
    headers: {
      'Access-Control-Allow-Origin': '*',
    },
    disableHostCheck: true,
  },
  resolve: {
    extensions: ['.js', '.vue'],
    modules: [absPath('node_modules'), absPath('frontEndSources')],
    alias: {
      vue$: 'vue/dist/vue.esm.js',
      Modules: absPath('frontEndSources/components/'),
    },
  },
  module: {
    rules: [
      {
        test: /\.(js|vue)$/,
        loader: 'eslint-loader',
        enforce: 'pre',
        include: absPath('frontEndSources/'),
      },
      {
        test: /\.vue$/,
        loader: 'vue-loader',
        include: absPath('frontEndSources/'),
        options: {
          loaders: {
            scss: CSS_STACK({ vue: true }),
            css: CSS_STACK({ scss: false, vue: true }),
          },
        },
      },
      {
        test: /\.scss$/,
        include: absPath('frontEndSources/'),
        use:
          env === 'production'
            ? ExtractTextPlugin.extract({
                use: CSS_STACK({ production: env === 'production' }),
              })
            : CSS_STACK(),
      },
      {
        test: /\.js$/,
        loader: 'babel-loader',
        include: absPath('frontEndSources/'),
      },
    ],
  },
  plugins: [
    new webpack.HotModuleReplacementPlugin(),
    new webpack.ProgressPlugin(),
    new webpack.NamedModulesPlugin(),
    ...(env === 'production'
      ? [
          new webpack.DefinePlugin({
            'process.env': {
              NODE_ENV: JSON.stringify('production'),
            },
          }),
          new ExtractTextPlugin({
            filename: 'css/CraftGonzo.css',
            allChunks: true,
          }),
          new UglifyJsPlugin({
            uglifyOptions: {
              compress: {
                warnings: false,
              },
            },
            sourceMap: true,
            parallel: true,
          }),
          new webpack.LoaderOptionsPlugin({
            minimize: true,
          }),
          new BundleAnalyzerPlugin({
            analyzerMode: 'disabled',
            generateStatsFile: true,
            statsFilename: absPath('webpack/stats.json'),
            logLevel: 'info',
          }),
        ]
      : []),
  ],
});

export default webpackConfig;
