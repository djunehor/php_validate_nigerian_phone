 Nigerian Phone Number Validator (PHP)
[![HitCount](http://hits.dwyl.io/djunehor/php_validate_nigerian_phone.svg)](http://hits.dwyl.io/djunehor/php_validate_nigerian_phone) [![CircleCI](https://circleci.com/gh/djunehor/php_validate_nigerian_phone.svg?style=svg)](https://circleci.com/gh/djunehor/php_validate_nigerian_phone)

#### Issues and pull requests welcome.

A Python module to validate and format a Nigerian phone number as well as deduce the network provider or area code.

### Table of Contents
* [Installation](#installation)
* [Usage](#usage)
* [Features](#features)
* [Contribute](#contribute)
* [Run Tests](#tests)

## Installation
You will need [PHP 7.x](https://www.php.net/) and [composer](https://getcomposer.org/download/).

Install using composer: `composer require djunehor/validate_nigerian_phone`

## Usage

```php
use \Djunehor\Validator\NigerianPhone;

$phone = new NigerianPhone('+2348135087966');

// Check if is valid
$phone->isValid(); // true

// Get formatted
$phone->formatted(); // 08135087966

// Get Network
$phone->getNetwork(); // mtn

// Check if is mtn
$phone->isMtn(); // True


// Get network from phone number prefix e.g
$phone->getNetworkByPrefix('0703'); // mtn

```

## Features
### Currently implemented
* isValid
* formatted
* getNetwork
* getAreaCode
* isMtn
* isGlo
* isAirtel
* is9mobile
* isSmile
* isMultilinks
* isVisafone
* isNtel
* isStarcomms
* isZoom
* getPrefixesByNetwork
* getNetworkByPrefix
* getAreaCodeByName

### Tests
* Run `phpunit tests/NigerianPhoneTest.php`

## Contribute
Check out the issues on GitHub and/or make a pull request to contribute!
