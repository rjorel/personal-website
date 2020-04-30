/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from 'vue';
import VueRouter from 'vue-router';
import RepositoryComponent from './components/RepositoryComponent';
import hljs from 'highlight.js/lib/highlight';

window.$ = window.jQuery = require('jquery');

require('popper.js');
require('bootstrap');

window.Vue = Vue;

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use(VueRouter);

Vue.component('repository-component', RepositoryComponent);

Vue.directive('highlightjs', {
    deep: true,
    bind: function (el, binding) {
        const targets = el.querySelectorAll('code');

        targets.forEach((target) => {
            if (binding.value) {
                target.textContent = binding.value;
            }

            hljs.highlightBlock(target);
        });
    }
});

new Vue({
    el: '#app'
});

hljs.registerLanguage('casio', require('highlight.js/lib/languages/basic'));
hljs.registerLanguage('brainfuck', require('highlight.js/lib/languages/brainfuck'));
hljs.registerLanguage('cpp', require('highlight.js/lib/languages/cpp'));
hljs.registerLanguage('lisp', require('highlight.js/lib/languages/lisp'));
hljs.registerLanguage('makefile', require('highlight.js/lib/languages/makefile'));
hljs.registerLanguage('ocaml', require('highlight.js/lib/languages/ocaml'));
hljs.registerLanguage('prolog', require('highlight.js/lib/languages/prolog'));
hljs.registerLanguage('python', require('highlight.js/lib/languages/python'));
