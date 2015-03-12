# Changelog #

*These logs may be outdated or incomplete.*

## 4.0.0 ##

* Updated to PHP 5.3
* Fixed Composer issues

## 3.1 ##

* Added Composer support
* Replaced errors with exceptions
* Refactored to use strict equality

## 3.0 ##

* Added a basic caching and compression system
* Rewriting checkPath() to work correctly
* Converting private members to protected
* Can now render without a layout
* bind() now accepts an array or string

## 2.0 ##

* Completely rewritten from the ground up; not compatible (at all) with older versions
* Variables are now bound globally instead of per template
* Can configure what ext, layout and path to use
* Uses output buffering to render the templates
* Templates can use the $this variable as it is within the Gears scope
* Removed the cumbersome parent/child hierarchy

## 1.8 ##

* First initial release of Gears
