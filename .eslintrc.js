module.exports = {
  env: {
    browser: true,
    es6: true,
    amd: true
  },
  root: true,
  parserOptions: {
    parser: 'babel-eslint',
    sourceType: 'module'
  },
  extends: [
    // https://github.com/feross/standard/blob/master/RULES.md#javascript-standard-style
    'airbnb-base',
    'plugin:vue/recommended',
    'plugin:import/errors',
    'plugin:import/warnings'
  ],
  settings: {
    'import/resolver': {
      webpack: {
        config: 'webpack/webpack.config.babel.js'
      }
    }
  },
  // add your custom rules here
  rules: {
    camelcase: 0,
    complexity: [2, 10],
    'no-console': 0,
    'no-bitwise': 2,
    eqeqeq: 2,
    'wrap-iife': 2,
    'no-empty': 2,
    'no-use-before-define': 2,
    'no-caller': 2,
    'no-new': 0,
    'no-param-reassign': [
      2,
      {
        props: false
      }
    ],
    quotes: [2, 'single'],
    strict: [2, 'global'],
    'no-debugger': process.env.NODE_ENV === 'production' ? 2 : 0,
    'no-undef': 2,
    'no-unused-vars': [
      'error',
      {
        args: 'none'
      }
    ],
    'max-len': [2, 220],
    'comma-style': [2, 'last'],
    'dot-notation': 2,
    'brace-style': [2, '1tbs', { allowSingleLine: false }],
    'one-var': [2, 'never'],
    'operator-linebreak': [2, 'before'],
    'space-infix-ops': 2,
    'space-before-blocks': [2, 'always'],
    'eol-last': 2,
    'new-cap': 'off',
    'no-new': 'off',
    camelcase: 'off',
    'no-underscore-dangle': 'off',
    indent: ['error', 2],
    'import/no-unresolved': 0,
    'import/extensions': [
      'error',
      'always',
      {
        js: 'never',
        vue: 'never'
      }
    ],
    'no-trailing-spaces': [
      'error',
      {
        skipBlankLines: true,
        ignoreComments: true
      }
    ],
    'vue/max-attributes-per-line': [
      2,
      {
        singleLine: 3,
        multiLine: {
          max: 3,
          allowFirstLine: true
        }
      }
    ]
  }
};
