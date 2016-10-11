# Slim 3 API Skeleton

This is an API skeleton using [Slim 3](http://www.slimframework.com) with content negotiation, authentication, error handling, cache and performance in mind.
Error and exception handling is already configured for you. Check `config/dependencies.php` file. 

### Content Negotiation
Content Negotiation is handled using a query parameter and the HTTP Header "Accept".
- The default query parameter is `"output"` and possible values are (`"json" or "xml"`).
- If `"output"` parameter is not provided the HTTP Header `"Accept"` is used to determine which `"Content type"`.
If is not containing `"application/json"` or `"application/xml"` the default output will be `"json"`.

This project use the following packages/components:
- [Monolog](https://github.com/Seldaek/monolog) for logging.
- [Slim-HttpCache](https://github.com/slimphp/Slim-HttpCache). [Read more](http://www.slimframework.com/docs/features/caching.html)
- [Noodlehaus's Config](https://github.com/hassankhan/config) to load `env.php` file.
- [PHPUnit](https://phpunit.de/) for testing.

You can integrate any third-party components found on [Packagist](https://packagist.org):
- [Slim-Csrf](https://github.com/slimphp/Slim-Csrf/). [Read more](http://www.slimframework.com/docs/features/csrf.html)
- [Slim-Flash](https://github.com/slimphp/Slim-Flash). [Read more](http://www.slimframework.com/docs/features/flash.html)

### Run it:

1. `$ cd my-app`
2. `$ php -S 0.0.0.0:8888 -t public public/index.php`
3. Browse to http://localhost:8888

## Key directories

* `app/`: directory contains the core code of your application. All class files within the `App` namespace.
* `app/Controllers/`: directory contains controllers and actions classes.
* `app/Handlers/`: directory contains handlers classes (Error, PhpError, NotFound, NotAllowed).
* `app/Helpers/`: directory contains helpers classes.
* `app/Middleware/`: directory contains middleware classes.
* `app/Renders/`: directory contains renders classes for specific responses (json and xml).
* `bootstrap/`: directory contains files that bootstrap the framework and configure autoloading.
* `cache/`: directory contains framework generated files for performance optimization such as the route file. Should be writable by your web server.
* `cache/routes/`: directory is used to store routes generated files. For better performance on production. Should be writable by your web server.
* `config/`: directory contains all of your application's configuration files (settings, dependencies, middleware).
* `logs/`: directory contains your application's log files. Should be writable by your web server.
* `public/`: directory contains the index.php file, which is the entry point for all requests entering your application.
* `routes/`: directory contains all of the route definitions for your application. By default, 1 route file is included: `routes.php`.
* `tests/`: directory contains your automated tests. An example [PHPUnit](https://phpunit.de/) is provided out of the box. To run tests: `phpunit -- verbose tests/DefaultRoutesTest.php`.
* `vendor/`: directory contains your [Composer](https://getcomposer.org/) dependencies.

## Key files

* `public/index.php`: entry point to application.
* `bootstrap/app.php`: bootstrap the framework, configure auto-loading, dependencies, routes, etc.
* `env.php.dist`: environment settings. Must copy it to env.php and modify that one.
* `config/dependencies.php`: services for Pimple. Including (Database, Exception/Error handlers, Logger, etc).
* `config/middleware.php`: application middleware.
* `config/settings.php`: slim and others configurations. Rewrite Slim default settings (displayErrorDetails, routerCacheFile).
* `routes/routes.php`: all application routes are here.
* `app/Controllers/ExampleAction.php`: example Action class.
* `app/Helpers/ArrayToXml.php`: Helper class to convert array to xml. Used by XmlApiView class. 
* `app/Renders/ApiView.php`: Render output based on a PSR-7 Request's Accept header.
* `app/Renders/JsonApiView.php`: view wrapper for json responses (with error code). Return "meta" and "data". "meta" contains "error" (true/false) and "status" (HTTP Status code).
* `app/Renders/XmlApiView.php`: view wrapper for xml responses (with error code). Return "meta" and "data". "meta" contains "error" (true/false) and "status" (HTTP Status code).
