# SpiffyRoutes Module

SpiffyRoutes is a module intended to make setting up routes quicker by providing annotations that can be
used directly on the controllers/actions themselves. SpiffyRoutes comes feature complete with caching and a
CLI tool to warm/clear the cache as required.

## Project Status

[![Master Branch Build Status](https://secure.travis-ci.org/spiffyjr/spiffy-routes.png?branch=master)](http://travis-ci.org/spiffyjr/spiffy-routes)
[![Coverage Status](https://coveralls.io/repos/spiffyjr/spiffy-routes/badge.png?branch=master)](https://coveralls.io/r/spiffyjr/spiffy-routes?branch=master)

## Installation

Installation of SpiffyRoutes uses composer. For composer documentation, please refer to
[getcomposer.org](http://getcomposer.org/).

```sh
php composer.phar require spiffy/spiffy-routes:dev-master
```

Then add `SpiffyRoutes` to your `config/application.config.php`

Installation without composer is not officially supported, and requires you to install and autoload
the dependencies specified in the `composer.json`.

## Supported Annotations

Below is a list of currently supported annotations. This list will be updated as more annotations are supported. In order
to use the annotations you **must important them first**. Do this by putting the following at the top of your code,

```php
<?php

use SpiffyRoutes\Annotation as Route;
```

This will let you use SpiffyRoute's annotations using `@Route` in your docblock.

### Root

The root annotation is used on the *controller* level and specifies the prefix to apply to all routes
on actions inside the controller.

```php
<?php

use SpiffyRoutes\Annotation as Route;

/**
 * @Route\Root("/my")
 */
class MyController
{
    /**
     * @Route\Literal("/home")
     */
    public function indexAction()
    {
        // ... I resolve to /my/home
    }
}
```

### Literal

The literal annotation maps to the literal route type.


```php
<?php

use SpiffyRoutes\Annotation as Route;

class MyController
{
    /**
     * @Route\Literal("/home", name="index")
     */
    public function indexAction()
    {
        // ... I resolve to "/home", with name "index"
    }
}
```

### Regex

The literal annotation maps to the literal route type.


```php
<?php

use SpiffyRoutes\Annotation as Route;

class MyController
{
    /**
     * @Route\Regex("/regex/(?<id>\d+)", spec="/regex/%id%")
     */
    public function indexAction()
    {
        // ... I resolve to "/regex/<someid>"
    }
}
```

### Segment

The literal annotation maps to the literal route type.


```php
<?php

use SpiffyRoutes\Annotation as Route;

class MyController
{
    /**
     * @Route\Segment("/segment[/:id]", constraints={"id"="\d+"})
     */
    public function indexAction()
    {
        // ... I resolve to "/segment/<someid>", or /segment
    }
}
```

## Caching

Caching is extremely important due to the amount of reflection required to parse the annotations. It's so important,
in fact, that caching is *not* optional. You can, however, set the cache adapter to `Zend\Cache\Storage\Adapter\Memory`
during development if you wish to rebuild the router configuration on every request.

By default, caching is enabled using the `SpiffyRoutes\Cache` service which is a `Zend\Cache\Storage\AdapterFilesystem`
with the cache path set to `data/spiffy-routes`.

## Multiple Routes

SpiffyRoutes supports multiple routes per index. To use them, simply add more annotations to your actions.

```php
<?php

use SpiffyRoutes\Annotation as Route;

class MyController
{
    /**
     * @Route\Regex("/regex/(?<id>\d+)", spec="/regex/%id%")
     * @Route\Segment("/segment[/:id]", constraints={"id"="\d+"})
     */
    public function indexAction()
    {
        // ... I resolve to "/segment/<someid>", or /segment, or /regex/<someid>
    }
}
```

## CLI Tool

A CLI tool is provided to build and clear the cache. Run your `public/index.php` from a console to see the relevent
information.

## Automatic Route Names

It's recommended that you specify a name for all routes e.g., `@Route\Literal("/", name="home")`. Failure to do so will
cause an automated route name to be generated based on a canonicalized version of the controller and action name.

For example, if you have a controller registered with the ControllerManager as `My\Controller` and are a adding a route
to the `indexAction` the auto-generated route name would be `my_controller_index`.
