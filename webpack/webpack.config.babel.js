import path from 'path';
import webpack from 'webpack';

const absPath = dir => path.resolve(__dirname, `../${dir}`);

const webpackConfig = env => ({
  devtool: 'cheap-eval-source-map',
  entry: {
    app: absPath('frontEndSources/CraftGonzo.js')
  },
  output: {
    path: absPath('src/assetbundles/gonzo/dist/'),
    publicPath: '',
    filename: 'js/Craft3Gonzo.js',
    chunkFilename: 'js/[id].js'
  },
  devServer: {
    contentBase: absPath('resources/'),
    https: true,
    hot: true,
    inline: true,
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
            scss: [{ loader: 'vue-style-loader' }, { loader: 'css-loader' }, { loader: 'sass-loader' }]
          }
        }
      },
      {
        test: /\.js$/,
        loader: 'babel-loader',
        include: absPath('frontEndSources/')
      }
    ]
  },
  plugins: [new webpack.HotModuleReplacementPlugin(), new webpack.ProgressPlugin(), new webpack.NamedModulesPlugin()]
});

export default webpackConfig;
