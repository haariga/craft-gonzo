/* eslint-env node */
require("@rushstack/eslint-patch/modern-module-resolution");

module.exports = {
  "root": true,
  "parser": "vue-eslint-parser",
  "parserOptions": {
    "parser": "@typescript-eslint/parser",
    "ecmaVersion": 2020,
    "sourceType": "module"
  },
  "rules": {
    "no-undef": "off",
    "quotes": [1, "single"]
  },
  "env": {
    "browser": true,
    "amd": true,
    "node": true
  },
  "plugins": [
    "@typescript-eslint"
  ],
  "extends": [
    "plugin:vue/vue3-essential",
    "eslint:recommended",
    "@vue/eslint-config-typescript/recommended",
    "@vue/eslint-config-prettier"
  ]
}
