<?php

declare(strict_types=1);

use \Djunehor\Validator\NigerianPhone;
use \PHPUnit\Framework\TestCase;

class NigerianPhoneTest extends TestCase {

	public static $validNumbers = [
		'+2348135087966',
		'2348135087966',
		'08135087966',
		'8135087966',
		'04221542',
//		'+234 0 256 7854',
		'0425 5832'
	];

	public static $phones = [
		'+2348135087966' => 'mtn',
		'08022334455'    => 'airtel',
		'2348182334455' => '9mobile',
		'8052233455'    => 'glo',
		'08197456754'    => 'starcomms',
//		'08117456754'    => null,
	];

	public static $wrongPhones = [
		'+2346135087966',
		'06022334455',
	];

	public static $landLines = [
		'04221542'        => 'Enugu',
//		'+234 5 2569 754' => 'Benin City',
		'0355 5832'       => 'Oshogbo'
	];

	public static $wrongLandLines = [
		'00221542',
		'+234 9 256 7854',
		'0995 5832'
	];

	public static $wrongNumbers = [
		'2345067546789',
		'90239289'
	];

	public static $correctPrefixes = [
		'0703' => 'mtn',
		'0802' => 'airtel',
		'0809' => '9mobile',
		'0707' => 'zoom'
	];

	public static $wrongPrefixes = [
		'0801' => null,
		'0602' => null,
		'0819' => null,
	];

	public static $areaCodes = [
		'Ilorin'        => '31',
		'New Bussa'     => '33',
		'Akure'         => '34',
		'Munami' => null
	];

	public function testValidNumbers() {
		foreach ( self::$validNumbers as $case ) {
			$app = new NigerianPhone( $case );

			$this->assertTrue( $app->isValid() );
		}
	}

	public function testInvalidNumbers() {
		foreach ( self::$wrongNumbers as $case ) {
			$app = new NigerianPhone( $case );
			$this->assertTrue( $app->isValid() == false );
		}
	}

	public function testIsPhone() {
		foreach ( self::$phones as $phone => $value ) {
			$app = new NigerianPhone( $phone );

			$this->assertTrue( $app->isValidPhone );
		}
	}

	public function testIsNotPhone() {
		foreach ( self::$wrongPhones as $phone => $value ) {
			$app = new NigerianPhone( $phone );
			$this->assertTrue( $app->isValidPhone == false );
		}
	}

	public function testIsLandLine() {
		foreach ( self::$landLines as $phone => $value ) {
			$app = new NigerianPhone( $phone );
			$this->assertTrue( $app->isValidLandLine );
		}
	}

	public function testIsNotLandLine() {
		foreach ( self::$wrongLandLines as $phone => $value ) {
			$app = new NigerianPhone( $phone );
			$this->assertFalse( $app->isValidLandLine );
		}
	}

	public function testNetwork() {
		foreach ( self::$phones as $phone => $network ) {
			$app = new NigerianPhone( $phone );
			$this->assertTrue( $app->getNetwork() == $network );
		}
	}

	public function testAreaCode() {
		foreach ( self::$landLines as $phone => $network ) {
			$app = new NigerianPhone( $phone );
			$this->assertTrue( $app->getAreaCode() == $network );
		}
	}

	public function testPrefix() {
		foreach ( self::$correctPrefixes as $prefix => $network ) {
			$app = new NigerianPhone();
			$this->assertTrue( $app->getNetworkByPrefix( $prefix ) == $network );
		}
	}

	public function testGetAreaCodeByName() {
		foreach ( self::$areaCodes as $area => $code ) {
			$app = new NigerianPhone();
			$this->assertTrue( $app->getAreaCodeByName( $area ) == $code );
		}
	}
}
