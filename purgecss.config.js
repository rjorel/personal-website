module.exports = {
  content: [
    './assets/**/*.js',
    './templates/**/*.html.twig'
  ],
  safelist: [
    'collapsing',         // Menu.
    /^img-(start|end)$/,  // Repository images.
    /^hljs.*$/            // Syntax highlighting.
  ]
};
