<?php

namespace Djunehor\Validator;
use Validator;

use Illuminate\Support\ServiceProvider;
use Djunehor\Validator\NigerianPhone;

class PhoneValidatorServiceProvider extends ServiceProvider {
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */

	protected $message = 'The phone number you provided is not valid!';

	public function boot() {
		Validator::extend('ngphone', function ($attribute, $value, $parameters, $validator) {

			$phone = new NigerianPhone($value);
			$type = (!empty($parameters)) ? head($parameters) : null;

			switch ($type) {
				case 'mobile':
					return $phone->isValidPhone;
					break;
				case 'land':
					return $phone->isValidLandLine;

				default:
					return $phone->isValid();
			}

		}, $this->message);
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register() {

	}

}
