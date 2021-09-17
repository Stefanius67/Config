# Read and merge configuration files of different formats

 ![Latest Stable Version](https://img.shields.io/badge/release-v1.1.0-brightgreen.svg)
 ![License](https://img.shields.io/packagist/l/gomoob/php-pushwoosh.svg) 
 [![Donate](https://img.shields.io/static/v1?label=donate&message=PayPal&color=orange)](https://www.paypal.me/SKientzler/5.00EUR)
 ![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.4-8892BF.svg)
 [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Stefanius67/Config/badges/quality-score.png?b=main&s=83ec79d99dfd102d2a89d33c72fa55cd93536063)](https://scrutinizer-ci.com/g/Stefanius67/Config/?branch=main)
 [![codecov](https://codecov.io/gh/Stefanius67/Config/branch/main/graph/badge.svg?token=RQS0S0G9KH)](https://codecov.io/gh/Stefanius67/Config)
 
----------
## New in Version 1.1.0
- Added support for YAML and NEON config files
- New method `setPathSeparator()` to change default path separator ('.')

## Overview

This package provides a general interface that grant access to configuration settings 
of different sources and/or formats.

#### Following Formats are supported so far:

- JSON
- INI (flat INI file like 'usual' windwos INI-Files supporting sections and entries)
- XML
- YAML
- NEON
- directly from an Array (content may result from a DB query)

In addition, the package offers the possibility of merging several configurations 
from different sources and / or in different formats into one object, which can then 
be used by any module.

There is thus the possibility of e.g. Merge global and local or general and 
user-specific configurations without the processing module having to know where what 
information comes from.

A `NullConfig` class is also included that can be used for testing. Also this class 
can be used if it is desired to make a module working completly independent with 
default configuration values and optional can have external configuration be passed.

## Usage
1. Create an instance of the class that supports the desired format.
2. Pass this instance to any module that supports the `ConfigInterface`
3. inside the module get the needed config settings with `the getXXX($strPath, $default)` - Methods

See ConfigExample.php

For the format of the configuration files see the seeral examples comming with this package.


## History
##### 2021-01-05	Version 1.0.0
- *initial Version*

##### 2021-08-01	Version 1.1.0
- *Added support for YAML and NEON config files*
- *New method `setPathSeparator()` to change default path separator ('.')*
