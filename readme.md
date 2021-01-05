# Read configuration files of different formats (INI, JSON, XML,...)

 ![Latest Stable Version](https://img.shields.io/badge/release-v1.0.0-brightgreen.svg)
 ![License](https://img.shields.io/packagist/l/gomoob/php-pushwoosh.svg) 
 [![Donate](https://img.shields.io/static/v1?label=donate&message=PayPal&color=orange)](https://www.paypal.me/SKientzler/5.00EUR)
 ![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.4-8892BF.svg)
 [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Stefanius67/Config/badges/quality-score.png?b=main&s=83ec79d99dfd102d2a89d33c72fa55cd93536063)](https://scrutinizer-ci.com/g/Stefanius67/Config/?branch=main)
 
----------
## Overview

This package provides a general interface via which configuration settings can be 
read from different sources / formats.
Following Formats are supported so far:

- JSON
- INI
	- flat INI file like 'usual' windwos INI-Files supporting sections and entries
- XML

## Usage
1. Create an instance of the class that supports the desired format.
2. Pass this instance to any module that supports the `ConfigInterface`
3. inside the module get the needed config settings with `the getXXX($strPath, $default)` - Methods

See ConfigExample.php

## Logging
This package can use any PSR-3 compliant logger. The logger is initialized with a NullLogger-object 
by default. The logger of your choice have to be passed to the constructor of the GCalAddEventLink class. 

If you are not working with a PSR-3 compatible logger so far, this is a good opportunity 
to deal with this recommendation and may work with it in the future.  

There are several more or less extensive PSR-3 packages available on the Internet.  

You can also take a look at the 
 [**'XLogger'**](https://www.phpclasses.org/package/11743-PHP-Log-events-to-browser-console-text-and-XML-files.html)
package and the associated blog
 [**'PSR-3 logging in a PHP application'**](https://www.phpclasses.org/blog/package/11743/post/1-PSR3-logging-in-a-PHP-application.html)
as an introduction to this topic.


## History
##### 2021-01-05	Version 1.00
  * initial Version
