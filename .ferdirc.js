const defaults = {
  template: false,
  css: false,
  javascript: false,
  vue: true,
  fractal: false
};

module.exports = {
  fileHeader: {
    authors: [
      {
        name: 'Martin Herweg',
        email: 'martin@herweg.co'
      }
    ],
    projectName: 'Gonzo'
  },
  files: {
    template: {
      name: '',
      postfix: 'template',
      extension: 'html',
      description: 'ferdi should create a Template File',
      default: defaults.template
    },
    css: {
      name: '',
      postfix: 'style',
      extension: 'scss',
      description: 'ferdi should create Stylesheet File',
      default: defaults.css
    },
    javascript: {
      name: '',
      postfix: 'script',
      extension: 'js',
      description: 'ferdi should create JavaScript File',
      default: defaults.javascript
    },
    vue: {
      name: '',
      postfix: '',
      extension: 'vue',
      default: defaults.vue
    },
    fractal: {
      name: '',
      postfix: 'config',
      extension: 'js',
      default: defaults.fractal
    }
  },
  paths: {
    templateBase: 'tmpl/',
    modulePath: 'src/components/',
    pathOptions: {
      // the first character of each key works as an alias for the path so you could use `-a` as an alias for atomic
    }
  }
};

exports.defaults = defaults;
