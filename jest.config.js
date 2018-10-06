const path = require('path');
const config = require('./package');

const absPath = (dir = '') => path.resolve(__dirname, `../${dir}`);
console.log(absPath());
const assetBundles = (dir = '') =>
  path.resolve(__dirname, '..', 'src', 'assetbundles', 'gonzo', dir);

module.exports = {
  setupFiles: ['jest-localstorage-mock'],
  transformIgnorePatterns: ['<rootDir>/node_modules/(?!(lodash-es|mo-js|lodash)/)'],
  testPathIgnorePatterns: ['<rootDir>/__tests__/__mocks__', '<rootDir>/__tests__/transformers'],
  moduleFileExtensions: ['js', 'json', 'vue'],
  moduleNameMapper: {
    '^@/(.*)$': '<rootDir>/src/assetbundles/gonzo/src/$1',
    '^@Root/(.*)$': absPath('craft-gonzo'),
    '^@Src/(.*)$': absPath('src'),
    '^@Css/(.*)$': assetBundles('src/scss/'),
    '^@Js/(.*)$': assetBundles('src/js'),
    // '^@Images/(.*)$': resolve(config.srcPaths.images.base),
    // '^@Svg/(.*)$': resolve(config.srcPaths.images.svg.base),
    // '^@Fonts/(.*)$': resolve(config.srcPaths.fonts),
    '^@State/(.*)$': assetBundles('src/vue/store/'),
    '^@Router/(.*)$': assetBundles('src/vue/router/'),
    '^@Components/(.*)$': assetBundles('src/vue/components/'),
    '^@Views/(.*)$': assetBundles('src/vue/views/'),
  },
  transform: {
    '^.+\\.vue$': 'vue-jest',
    '^.+\\.js$': 'babel-jest',
    '.+\\.(css|styl|less|sass|scss|png|jpg|svg|ttf|woff|woff2)$':
      '<rootDir>/__tests__/transformers/fileTransformer.js',
  },
  snapshotSerializers: ['jest-serializer-vue'],
};
