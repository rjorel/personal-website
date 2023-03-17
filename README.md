# Personal website

## About
This is my personal website. Not an incredible one, just a way to present myself, some achievements and skills, and
sharing little projects.

After making a _from scratch_ version and Laravel-based one, I decided to develop again it by using famous PHP and JS
packages (Symfony requests, Twig, Vite and so on). Nothing new, just a gathering of existing components.

Even if it's not a piece of art, I think it can be an example of how to build simple websites..

## How it works
### Inspiration
As I am a huge  [Laravel](https://laravel.com/) fan, the structure is really inspired by Laravel one. The concept of
service providers, core `Application` and `Kernel` classes, even `index.php` are highly inspired by this (incredible)
framework.

I think you've understood: I love Laravel.. but for a simple website, it's a little heavy and
[Lumen](https://lumen.laravel.com/) is designed for building API. So, a Laravel-inspired structure appeared to me as the
best solution.

### Core
Core system is basically designed to handle requests and send responses, regardless of how these responses are built. A
simple routing algorithm is implemented, to search across URIs and execute controller actions. URIs and template engine
(Twig) are registered at app level, not in the core, using service providers.

### Service providers
It's a simple way to add services to the application. Registering service providers in `App\AppConfig` class allows  to
configure and add any services to the application in a not-so-bad way.

### Routes
Routes are registered via `App\Providers\RouteServiceProvider` class.

### Twig extension
I use Vite to bundle assets. In production, output files are minified and versioned, but Twig does not natively include
an extension to handle them. Twig Vite asset extension is inspired by Laravel `Vite` 
[class](https://github.com/laravel/framework/blob/master/src/Illuminate/Foundation/Vite.php).

### Repository
Repository uses JS to be interactive and avoid page reloading for each visited file or directory. Information about the
current visited file is requested via the `p=` parameter in request.

### Sitemap generation
Making and updating a sitemap file is usually boring. Because repository may often change, it's more comfortable to
generate the sitemap.

### No tests
Yes, I know, that's really (really) bad.. but for my personal website, should I do test something? Maybe not..
