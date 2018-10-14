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
    '^@Root/(.*)$': `${absPath('craft-gonzo')}$1`,
    '^@Src/(.*)$': `${absPath('src')}$1`,
    '^@Css/(.*)$': `${assetBundles('src/scss/')}$1`,
    '^@Js/(.*)$': `${assetBundles('src/js')}$1`,
    // '^@Images/(.*)$': resolve(config.srcPaths.images.base),
    // '^@Svg/(.*)$': resolve(config.srcPaths.images.svg.base),
    // '^@Fonts/(.*)$': resolve(config.srcPaths.fonts),
    '^@State/(.*)$': `${assetBundles('src/vue/store/')}$1`,
    '^@Router/(.*)$': `${assetBundles('src/vue/router/')}$1`,
    '^@Components/(.*)$': `${assetBundles('src/vue/components/')}/$1`,
    '^@Views/(.*)$': `${assetBundles('src/vue/views/')}$1`,
  },
  transform: {
    '^.+\\.vue$': 'vue-jest',
    '^.+\\.js$': 'babel-jest',
    '.+\\.(css|styl|less|sass|scss|png|jpg|svg|ttf|woff|woff2)$':
      '<rootDir>/__tests__/transformers/fileTransformer.js',
  },
  snapshotSerializers: ['jest-serializer-vue'],
};
