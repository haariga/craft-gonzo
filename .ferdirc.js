module.exports = {
  defaults: {
    template: false,
    css: false,
    javascript: false,
    vue: true,
    fractal: false,
  },
  fileHeader: {
    authors: [
      {
        name: 'Martin Herweg',
        email: 'martin@herweg.co',
      },
    ],
    projectName: 'Gonzo',
  },
  files: {
    template: {
      name: '',
      postfix: 'template',
      extension: 'html',
      description: 'ferdi should create a Template File',
    },
    css: {
      name: '',
      postfix: 'style',
      extension: 'scss',
      description: 'ferdi should create Stylesheet File',
    },
    javascript: {
      name: '',
      postfix: 'script',
      extension: 'js',
      description: 'ferdi should create JavaScript File',
    },
    vue: {
      name: '',
      postfix: '',
      extension: 'vue',
    },
    fractal: {
      name: '',
      postfix: 'config',
      extension: 'js',
    },
  },
  paths: {
    templateBase: 'tmpl/',
    modulePath: 'frontEndSources/components/',
    pathOptions: {
      // the first character of each key works as an alias for the path so you could use `-a` as an alias for atomic
    },
  },
};
