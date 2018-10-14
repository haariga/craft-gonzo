import path from 'path';
import webpack from 'webpack';
import { getIfUtils, removeEmpty } from 'webpack-config-utils';
import { BundleAnalyzerPlugin } from 'webpack-bundle-analyzer';
import ExtractTextPlugin from 'extract-text-webpack-plugin';
import HtmlWebpackPlugin from 'html-webpack-plugin';
import HtmlWebpackHarddiskPlugin from 'html-webpack-harddisk-plugin';
import Stylish from 'webpack-stylish';

import VueLoaderPlugin from 'vue-loader/lib/plugin';

const absPath = dir => path.resolve(__dirname, `../${dir}`);
const assetBundles = (dir = '') =>
  path.resolve(__dirname, '..', 'src', 'assetbundles', 'gonzo', dir);

const webpackConfig = (env = {}) => {
  const { ifDevelopment, ifProduction } = getIfUtils(env);

  const CSS_STACK = ({
    scss = true,
    vue = false,
    sassResources = false,
    production = false,
  } = {}) => {
    const styleLoader = production
      ? []
      : [
          {
            loader: vue ? 'vue-style-loader' : production ? '' : 'style-loader',
          },
        ];

    const scssLoader = scss
      ? [
          {
            loader: 'sass-loader',
            options: {
              includePaths: [assetBundles('src/scss/')],
              data:
                "@import 'settings.variables';\n" +
                "@import 'tools.functions'; \n" +
                "@import 'tools.mixins';",
            },
          },
        ]
      : [];

    const sassResourcesLoader = sassResources
      ? [
          {
            loader: 'sass-resoures-loader',
            options: {
              resources: [
                assetBundles('src/scss/_variables.scss'),
                assetBundles('src/scss/_mixins.scss'),
                assetBundles('src/scss/_functions.scss'),
              ],
            },
          },
        ]
      : [];

    return [
      ...styleLoader,
      {
        loader: 'css-loader',
      },
      ...scssLoader,
      ...sassResourcesLoader,
    ];
  };

  const devPublic = 'http://localhost:8080/';

  return {
    entry: {
      app: assetBundles('src/main.js'),
    },
    output: {
      path: assetBundles('dist'),
      publicPath: ifProduction('', devPublic),
      filename: 'js/main.js',
      chunkFilename: 'js/[id].js',
      hotUpdateMainFilename: 'js/[hash].hot-update.json',
    },
    stats: 'none',
    devServer: {
      contentBase: absPath('resources/'),
      host: '0.0.0.0',
      publicPath: devPublic,
      hot: true,
      inline: true,
      overlay: true,
      stats: 'errors-only',
      watchOptions: {
        poll: true,
      },
      headers: {
        'Access-Control-Allow-Origin': '*',
      },
      disableHostCheck: true,
    },
    resolve: {
      extensions: ['.js', '.vue'],
      modules: [absPath('node_modules'), assetBundles('src')],
      alias: {
        vue$: 'vue/dist/vue.esm.js',
        Modules: assetBundles('src/vue/components/'),
        '@Components': assetBundles('src/vue/components/'),
        '@Views': assetBundles('src/vue/views/'),
      },
    },
    module: {
      rules: [
        {
          test: /\.(js|vue)$/,
          loader: 'eslint-loader',
          enforce: 'pre',
          include: assetBundles('src'),
        },
        {
          test: /\.vue$/,
          loader: 'vue-loader',
          include: assetBundles('src'),
        },
        {
          test: /\.css$/,
          loader: CSS_STACK({
            scss: false,
            vue: true,
          }),
        },
        {
          test: /\.scss$/,
          include: assetBundles('src'),
          use: ifProduction(
            ExtractTextPlugin.extract({
              use: CSS_STACK({ production: env.production }),
            }),
            CSS_STACK(),
          ),
        },
        {
          test: /\.js$/,
          loader: 'babel-loader',
          include: assetBundles('src'),
        },
      ],
    },
    plugins: [
      new VueLoaderPlugin(),
      new webpack.HotModuleReplacementPlugin(),
      new webpack.ProgressPlugin(),
      ...(env.production
        ? [
            new ExtractTextPlugin({
              filename: 'css/CraftGonzo.css',
              allChunks: true,
            }),
            new BundleAnalyzerPlugin({
              analyzerMode: 'disabled',
              generateStatsFile: true,
              statsFilename: absPath('webpack/stats.json'),
              logLevel: 'info',
            }),
          ]
        : []),
      new HtmlWebpackPlugin({
        filename: absPath('src/templates/patternlib.twig'),
        template: absPath('webpack/patternlib_webpack-template.twig'),
        inject: false,
        devServer: devPublic,
        environment: ifProduction('production', 'development'),
        alwaysWriteToDisk: true,
      }),
      new HtmlWebpackHarddiskPlugin(),
      new webpack.NamedModulesPlugin(),
      new Stylish(),
    ],
  };
};

export default webpackConfig;
