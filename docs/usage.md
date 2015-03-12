# Gears #

*Documentation may be outdated or incomplete as some URLs may no longer exist.*

*Warning! This codebase is deprecated and will no longer receive support; excluding critical issues.*

A PHP class that loads template files, binds variables to a single file or globally without the need for custom placeholders/variables, allows for parent-child hierarchy and parses the template structure.

Gear is a play on words for: Engine + Gears + Structure.

* Loads any type of file into the system
* Binds variables to a single file or to all files globally
* Template files DO NOT need custom markup and placeholders for variables
* Can access and use variables in a template just as you would a PHP file
* Allows for parent-child hierarchy
* Parse a parent template to parse all children, and their children, and so on
* Can destroy template indexes on the fly
* No eval() or security flaws
* And much more...

## Introduction ##

Most of the template systems today use a very robust setup where the template files contain no server-side code. Instead they use a system where they use custom variables and markup to get the job done. For example, in your template you may have a variable called {pageTitle} and in your code you assign that variable a value of "Welcome". This is all well and good, but to be able to parse this "system", it requires loads of regex and matching/replacing/looping which can be quite slow and cumbersome. It also requires you to learn a new markup language, specific for the system you are using. Why would you want to learn a new markup language and structure simply to do an if statement or go through a loop? In Gears, the goal is to remove all that custom code, separate your markup from your code, allow the use of standard PHP functions, loops, statements, etc within templates, and much more!

## Installation ##

Install by manually downloading the library or defining a [Composer dependency](http://getcomposer.org/).

```javascript
{
    "require": {
        "mjohnson/gears": "4.0.0"
    }
}
```

Once available, instantiate the class and create template files.

```php
// index.php
$temp = new mjohnson\gears\Gears(dirname(__FILE__) . 'templates/');
$temp->setLayout('layouts/default');

// templates/layouts/default.tpl
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $pageTitle; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
    <?php echo $this->getContent(); ?>
</body>
</html>
```

Within the code block above I am initiating the class by calling `new mjohnson\gears\Gears($path)` (where `$path` is the path to your templates directory) and storing it within a `$temp` variable. Next I am setting the layout I want to use; a layout is the outer HTML that will wrap the inner content pages. Within a layout you can use `getContent()` which will output the inner HTML wherever you please.

## Binding Variables ##

It's now time to bind data to variables within your templates; to do this we use the `bind()` method. The bind method will take an array of key value pairs, or key value arguments.

```php
$temp->bind(array(
    'pageTitle' => 'Gears - Template Engine',
    'description' => 'A PHP class that loads template files, binds variables, allows for parent-child hierarchy all the while rendering the template structure.'
));
```

The way binding variables works is extremely easy to understand. In the data being binded, the key is the name of the variable within the template, and the value is what the variable will be output. For instance the variable pageTitle (Gears - Template Engine) above will be assigned to the variable `$pageTitle` within the `layouts/default.tpl`.

Variables are binded globally to all templates, includes and the layout.

## Displaying the Templates ##

To render templates, use the `display()` method. The display method takes two arguments, the name of the template you want to display and the key to use for caching.

```php
echo $temp->display('index');
```

The second argument defines the name of the key to use for caching. Generally it will be the same name as the template name, but you do have the option to name it whatever you please.

```php
echo $temp->display('index', 'index');
```

It's also possible to display templates within folders by separating the path with a forward slash.

```php
echo $temp->display('users/login');
```

## Opening a Template ##

To render a template within another template you would use the `open()` method. The `open()` method takes 3 arguments: the path to the template (relative to the templates folder), an array of key value pairs to define as custom scoped variables and an array of cache settings.

```php
echo $this->open('includes/footer', array('date' => date('Y'));
```

By default, includes are not cached but you can enable caching by passing true as the third argument or an array of settings. The viable settings are key and duration, where key is the name of the cached file (usually the path) and duration is the length of the cache.

```php
echo $this->open('includes/footer', array('date' => date('Y')), true);

// Custom settings
echo $this->open('includes/footer', array('date' => date('Y')), array(
    'key' => 'cacheKey',
    'duration' => '+10 minutes'
));
```

## Caching ##

Gears comes packaged with a basic caching mechanism. By default caching is disabled, but to enable caching you can use `setCaching()`. This method will take the cache location as its 1st argument (best to place it in the same templates folder) and the expiration duration as the 2nd argument (default +1 day).

```php
$temp->setCaching(dirname(__FILE__) . '/templates/cache/');
```

You can customize the duration by using the strtotime() format. You can also pass null as the first argument and the system will place the cache files within your template path.

```php
$temp->setCaching(null, '+15 minutes');
```

To clear all cached files, you can use `flush()`.

```php
$temp->flush();
```

For a better example of how to output cached data, refer to the tests folder within the Gears package.
