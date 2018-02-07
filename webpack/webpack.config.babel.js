import path from 'path';
import webpack from 'webpack';
import ExtractTextPlugin from 'extract-text-webpack-plugin';

const absPath = dir => path.resolve(__dirname, `../${dir}`);

const CSS_STACK = ({ scss = true, vue = false, sassResources = false } = {}) => [
  {
    loader: vue ? 'vue-style-loader' : 'style-loader',
  },
  {
    loader: 'css-loader'
  },
  ...(scss ? [{
    loader: 'sass-loader'
  }] : {}),
  ...(sassResources ? [{
    loader: 'sass-resoures-loader',
    options: {
      resources: [absPath('frontEndSources/scss/_variables.scss'), absPath('frontEndSources/scss/_mixins.scss'), absPath('frontEndSources/scss/_functions.scss')]
    }
  }] : [])
];

const webpackConfig = env => ({
  devtool: 'cheap-eval-source-map',
  entry: {
    app: absPath('frontEndSources/CraftGonzo.js')
  },
  output: {
    path: absPath('src/assetbundles/gonzo/dist/'),
    publicPath: '',
    filename: 'js/Craft3Gonzo.js',
    chunkFilename: 'js/[id].js',
  },
  devServer: {
    contentBase: absPath('resources/'),
    hot: true,
    inline: true,
    overlay: true,
    headers: {
      'Access-Control-Allow-Origin': '*'
    }
  },
  resolve: {
    extensions: ['.js', '.vue'],
    modules: [absPath('node_modules'), absPath('frontEndSources')],
    alias: {
      vue$: 'vue/dist/vue.esm.js',
      Modules: absPath('frontEndSources/components/')
    }
  },
  module: {
    rules: [
      /*{
        test: /\.(js|vue)$/,
        loader: 'eslint-loader',
        enforce: 'pre',
        include: absPath('frontEndSources/')
      },*/
      {
        test: /\.vue$/,
        loader: 'vue-loader',
        include: absPath('frontEndSources/'),
        options: {
          loaders: {
            scss: CSS_STACK({ vue: true }),
            css: CSS_STACK({ scss: false, vue: true }),
          }
        }
      },
      {
        test: /\.scss$/,
        include: absPath('frontEndSources/'),
        use: env === 'production' ? ExtractTextPlugin.extract({
          fallback: 'style-loader',
          use: CSS_STACK(),
        }) : CSS_STACK(),
      },
      {
        test: /\.js$/,
        loader: 'babel-loader',
        include: absPath('frontEndSources/')
      }
    ]
  },
  plugins: [new webpack.HotModuleReplacementPlugin(), new webpack.ProgressPlugin(), new webpack.NamedModulesPlugin(),
            ...(env === 'production' ? [new ExtractTextPlugin({
              filename: 'css/Craft3Gonzo.css',
              allChunks: true,
            })] : [])
  ]
});

export default webpackConfig;
