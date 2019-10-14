 Nigerian Phone Number Validator (PHP)
[![HitCount](http://hits.dwyl.io/djunehor/php_validate_nigerian_phone.svg)](http://hits.dwyl.io/djunehor/php_validate_nigerian_phone) [![CircleCI](https://circleci.com/gh/djunehor/php_validate_nigerian_phone.svg?style=svg)](https://circleci.com/gh/djunehor/php_validate_nigerian_phone)

#### Issues and pull requests welcome.

A PHP module to validate and format a Nigerian phone number as well as deduce the network provider or area code.

## NOTE: The network resolution function can't be accurate because Nigeria implemented [Mobile Number Portability](https://en.wikipedia.org/wiki/Mobile_number_portability) in 2013, so the number prefix cannot be reliably used to determine operator anymore.

### Table of Contents
* [Installation](#installation)
* [Usage](#usage)
* [Features](#features)
* [Contribute](#contribute)
* [Run Tests](#tests)

## Installation
You will need >[PHP 5.6](https://www.php.net/) and [composer](https://getcomposer.org/download/).

Install using composer: `composer require djunehor/validate_nigerian_phone`

### In a Laravel project
* If using Laravel 5.5 and above, no further action required
* If you're using Laravel < 5.5, you'll need to register the service provider. Open up config/app.php and add the following to the providers array:
`Djunehor\Validator\PhoneValidatorServiceProvider::class`

## Usage
### In Laravel
```php
...

/*This checks if the number supplied
*is a valid nigerian number
* either land line or mobile number
*/
public function controllerName(Request $request) {
		$request->validate( [
			'phone' => 'required|ngphone'
		]);
	}
	
//to validate if it's a mobile number
$request->validate( [
			'phone' => 'required|ngphone:mobile'
		]);
		
//to validate if it's a landline
$request->validate( [
			'phone' => 'required|ngphone:land'
		]);		
```

# In a PHP project
If autoload is not enabled, add `require vendor/autoload.php` to the top of the file, then
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
