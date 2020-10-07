# Personal website

## About
This is my personal website. Not an incredible one, just a way to present myself, some achievements and skills, and to
share little projects.

After making a _from scratch_ version and Laravel-based one, I decided to re-develop it by using famous PHP and JS
packages (Symfony requests, Twig, Laravel mix and so on). Nothing new, just a gathering of existing components.

Even if it's not a piece of art, I think it can be an example of how to build simple websites..

## How it works

### Inspiration
As I am a huge  [Laravel](https://laravel.com/) fan, the structure is really inspired by Laravel one. The concept of
service providers, `Application` and `Kernel` classes, even `index.php` are highly inspired by this incredible
framework.

I think you understood : I love Laravel.. but for a simple website, it's a little bit heavy and
[Lumen](https://lumen.laravel.com/) is designed for building API. So a Laravel-inspired structure appeared to me as the
best solution.

### Service providers
It's a simple way to add services to the application. Registering a service provider in `Application` class allows to
configure and add any services to the application in a not-so-bad way (not in `index.php` for example).

### Routing
Routing is really basic, and routes are registered via `RouteServiceProvider` class.. not perfect, but sufficient.

### Twig extension
I use Laravel mix to compile CSS and JS files. In production, result files are minified and versioned, but Twig does not
natively include an extension to handle mix output. Twig mix extension is inspired by Laravel `Mix` 
[class](https://github.com/laravel/framework/blob/master/src/Illuminate/Foundation/Mix.php).

### Repository
Repository uses Vue to be interactive and avoid page reloading for each visited file or directory. Information about the
current visited file is requested via the `p` parameter in AJAX request.

### Sitemap generation
Making and updating a sitemap file is usually boring. And because repository may often change, it's more comfortable to
generate the sitemap. Unfortunately, this feature does not work for local development because Composer `serve` script,
as defined in `composer.json` file, can not handle URLs with dots.

### No tests
Yes, I know, that's really (really) bad.. but for a website, should I do test something? Maybe not..