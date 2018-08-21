import path from 'path';
import webpack from 'webpack';
import { getIfUtils, removeEmpty } from 'webpack-config-utils';
import { BundleAnalyzerPlugin } from 'webpack-bundle-analyzer';
import ExtractTextPlugin from 'extract-text-webpack-plugin';
import HtmlWebpackPlugin from 'html-webpack-plugin';
import HtmlWebpackHarddiskPlugin from 'html-webpack-harddisk-plugin';

import VueLoaderPlugin from 'vue-loader/lib/plugin';

const absPath = dir => path.resolve(__dirname, `../${dir}`);

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
                  includePaths: [absPath('frontEndSources/scss/')],
                  data: "@import 'settings.variables';\n" + "@import 'tools.functions'; \n" + "@import 'tools.mixins';",
              }
          },
        ]
      : [];

    const sassResourcesLoader = sassResources
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

  return {
    entry: {
      app: absPath('frontEndSources/CraftGonzo.js'),
    },
    output: {
      path: absPath('src/assetbundles/gonzo/dist/'),
      publicPath: ifProduction('', 'http://localhost:8080'),
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
        },
          {
            test: /\.css$/,
            loader: CSS_STACK({ scss: false, vue: true }),
          },
        {
          test: /\.scss$/,
          include: absPath('frontEndSources/'),
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
          include: absPath('frontEndSources/'),
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
        devServer: 'http://localhost:8080',
        environment: ifProduction('production', 'development'),
        alwaysWriteToDisk: true,
      }),
      new HtmlWebpackHarddiskPlugin(),
    ],
  };
};

export default webpackConfig;
