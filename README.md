
# Advanced Router

This router is an extension of my previous "Basic Router"-library for PHP, after I wrote that I started to need
more functions and changes in the router, this router was the result of this.

**Table of contents**
1. [Installation](#installation)
2. [Documentation](#documentation)
   1. [Instantiating the router object](#instantiate-the-router-object)
   2. [Creating routes](#creating-routes)

## Installation

```bash
composer require liamrabe/advanced-router
```

## Documentation

### Instantiate the router object

To start creating routes you need to first instantiate a `Router`-instance to add routes.\
In this documentation we'll assume the instance is named `$router`

```php
$router = \LiamRabe\AdvancedRouter\Router();
```

### Required methods

Before you can create routes you'll need to do some setup by running the required methods `setErrorController` and `setMiddleware`-methods,
these will set global middleware and error handler for routes.

Both `setMiddleware` and `setErrorController` takes 2 arguments, the first is the class handling the current request, the second is the handler for the middleware.

```php
$router->setMiddleware(AppMiddleware::class, 'handleRequest');
$router->setErrorController(AppErrorController::class, 'handleException');
```
