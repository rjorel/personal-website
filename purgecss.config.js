module.exports = {
  content: [
    './templates/**/*.html.twig'
  ],
  safelist: [
    'collapsing',         // Menu.
    /^img-(start|end)$/,  // Repository images.
    /^hljs.*$/            // Syntax highlighting.
  ]
};
