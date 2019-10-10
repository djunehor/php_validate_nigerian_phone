<?php
/*
Package Name: Nigerian Phone Number Validator
Description: Class to validate a Nigerian phone number as well as attempt to deduce the network.
Version: 1.0
Author: Zacchaeus (Djunehor) Bolaji
Author URI: https://github.com/djunehor
*/
namespace Djunehor\Validator;

use phpDocumentor\Reflection\Types\Self_;

class NigerianPhone {

	public static $allPrefixes = [
		'mtn'        => [
			'0803',
			'0703',
			'0903',
			'0806',
			'0706',
			'0813',
			'0814',
			'0816',
			'0810',
			'0906',
			'07025',
			'07026',
			'0704'
		],
		'glo'        => [ '0805', '0705', '0905', '0807', '0815', '0905', '0811' ],
		'airtel'     => [ '0802', '0902', '0701', '0808', '0708', '0812', '0901', '0907' ],
		'9mobile'    => [ '0809', '0909', '0817', '0818', '0908' ],
		'ntel'       => [ '0804' ],
		'smile'      => [ '0702' ],
		'multilinks' => [ '0709', '07027' ],
		'visafone'   => [ '07025', '07026', '0704' ],
		'starcomms'  => [ '07028', '07029', '0819' ],
		'zoom'       => [ '0707' ],
	];

	public static $allAreaCodes = [
		'Lagos'         => '01',
		'Ibadan'        => '02',
		'Abuja'         => '09',
		'Ado-Ekiti'     => '30',
		'Ilorin'        => '31',
		'New Bussa'     => '33',
		'Akure'         => '34',
		'Oshogbo'       => '35',
		'Ile-Ife'       => '36',
		'Ijebu-Ode'     => '37',
		'Oyo'           => '38',
		'Abeokuta'      => '39',
		'Wukari'        => '41',
		'Enugu'         => '42',
		'Abakaliki'     => '43',
		'Makurdi'       => '44',
		'Ogoja'         => '45',
		'Onitsha'       => '46',
		'Lafia'         => '47',
		'Awka'          => '48',
		'Ikare'         => '50',
		'Owo'           => '51',
		'Benin City'    => '52',
		'Warri'         => '53',
		'Sapele'        => '54',
		'Agbor'         => '55',
		'Asaba'         => '56',
		'Auchi'         => '57',
		'Lokoja'        => '58',
		'Okitipupa'     => '59',
		'Sokoto'        => '60',
		'Kafanchan'     => '61',
		'Kaduna'        => '62',
		'Gusau'         => '63',
		'Kano'          => '64',
		'Katsina'       => '65',
		'Minna'         => '66',
		'Kontagora'     => '67',
		'Birnin-Kebbi'  => '68',
		'Zaria'         => '69',
		'Pankshin'      => '73',
		'Azare'         => '71',
		'Gombe'         => '72',
		'Jos'           => '73',
		'Yola'          => '75',
		'Maiduguri'     => '76',
		'Bauchi'        => '77',
		'Hadejia'       => '78',
		'Jalingo'       => '79',
		'Aba, Nigeria'  => '82',
		'Owerri'        => '83',
		'Port Harcourt' => '84',
		'Uyo'           => '85',
		'Ahoada'        => '86',
		'Calabar'       => '87',
		'Umuahia'       => '88',
		'Yenagoa'       => '89',
		'Ubiaja'        => '55',
		'Kwara'         => '31',
		'Igarra'        => '57',
		'Ughelli'       => '53',
		'Uromi'         => '57'
	];

	public $prefixes, $areaCodes;
	public $isValidPhone = false;
	public $isValidLandLine = false;
	public $line = '';

	public function __construct( $line = null ) {
		foreach ( self::$allPrefixes as $key => $value ) {
			foreach ( $value as $item ) {
				$this->prefixes[] = $item;
			}
		}

		foreach ( self::$allAreaCodes as $key => $value ) {
			$this->areaCodes[] = $value;
		}

		if ($line) {
			$this->line = preg_replace( "/[^0-9]/", "", $line );
			$this->isValid();
		}

	}

	public function setLine($line) {
		$this->line = $line;
	}

	public function isValid() {
		# contains country calling code
		if ( substr( $this->line, 0, 3 ) == '234' ) {
			# phone number
			if ( strlen( $this->line ) == 13 ) {
				# remove country code for further analysis
				$stripCcc = str_replace( substr( $this->line, 0, 3 ), "0", $this->line );

				# contains valid phone prefix
				if ( in_array( substr( $stripCcc, 0, 5 ), $this->prefixes ) || in_array( substr( $stripCcc, 0, 4 ), $this->prefixes ) ) {
					$this->isValidPhone = true;

					return true;
				}
			}

			# is a land line
			elseif ( strlen( ( $this->line ) == 11 ) ) {
				# replace country code (234)
				$stripCcc = str_replace( substr( $this->line, 0, 3 ), "", $this->line );

				# contains valid 2-digit area code
				if ( in_array( substr( $stripCcc, 0, 2 ), $this->areaCodes )
				     && strlen( $stripCcc ) == 7) {
					$this->isValidLandLine = true;

					return true;
				}
			}
		}
		# doesn't contain country calling code
		else {
			# check if it starts with any prefix [0807,0906 etc..]
			if ( substr( $this->line, 0, 1 ) == '0' && strlen( $this->line ) == 11 && ( in_array( substr( $this->line, 0, 5 ), $this->prefixes ) || in_array( substr( $this->line, 0, 4 ), $this->prefixes ) ) ) {
				$this->isValidPhone = true;

				return true;
			}
			# check if it starts with any prefix without 0 e.g [807,906, 701 etc..]
			elseif ( strlen( $this->line ) == 10 && ( in_array( substr( $this->line, 0, 4 ), $this->prefixes ) || in_array( substr( $this->line, 0, 3 ), $this->prefixes ) ) ) {
				# add the missing zero for completion
				$this->line         = '0' . $this->line;
				$this->isValidPhone = true;

				return true;
			}
			# check if it's a land line starting with 0
			elseif ( substr( $this->line, 0, 1 ) == 0
			         && in_array( str_replace( substr( $this->line, 0, 1 ), "", substr( $this->line, 0, 3 ) ), $this->areaCodes )
			         && strlen( $this->line ) == 8 ) {
				$this->isValidLandLine = true;

				return true;
			}
		}

		return false;
	}

	public function formatted() {
		if ( substr( $this->line, 0, 3 ) == '234' ) {
			return str_replace( substr( $this->line, 0, 3 ), '0', $this->line );
		}

		return $this->line;
	}

	public function getNetwork() {
		if ( $this->isMtn() ) {
			return 'mtn';
		}
		elseif ( $this->isGlo() ) {
			return 'glo';
		}
		elseif ( $this->isAirtel() ) {
			return 'airtel';
		}
		elseif ( $this->is9mobile() ) {
			return '9mobile';
		}
		elseif ( $this->isSmile() ) {
			return 'smile';
		}
		elseif ( $this->isMultilinks() ) {
			return 'multilinks';
		}
		elseif ( $this->isVisafone() ) {
			return 'visafone';
		}
		elseif ( $this->isNtel() ) {
			return 'ntel';
		}
		elseif ( $this->isStarcomms() ) {
			return 'starcomms';
		}
		elseif ( $this->isZoom() ) {
			return 'zoom';
		}
		else {
			return 'unknown';
		}
	}

	public function getAreaCode() {
		$formatted   = $this->formatted();
		$removedZero = str_replace( '0', '', $formatted );
		$areaCode        = substr( $removedZero, 0, 2 );
		foreach ( self::$allAreaCodes as $area => $code ) {
			if ( $areaCode == $code ) {
				return $area;
			}

		}
		return null;
	}

	public function isMtn() {
		return ( in_array( substr( $this->formatted(), 0, 5 ), self::$allPrefixes['visafone'] ) or in_array( substr( $this->formatted(), 0, 4 ), self::$allPrefixes['mtn'] ) );
	}

	public function isGlo() {
		return ( in_array( substr( $this->formatted(), 0, 4 ), self::$allPrefixes['glo'] ) );
	}

	public function isAirtel() {
		return ( in_array( substr( $this->formatted(), 0, 4 ), self::$allPrefixes['airtel'] ) );
	}

	public function is9mobile() {
		return ( in_array( substr( $this->formatted(), 0, 4 ), self::$allPrefixes['9mobile'] ) );
	}

	public function isSmile() {
		return ( in_array( substr( $this->formatted(), 0, 4 ), self::$allPrefixes['smile'] ) );
	}

	public function isMultilinks() {
		return ( in_array( substr( $this->formatted(), 0, 5 ), self::$allPrefixes['multilinks'] )
		         || in_array( substr( $this->formatted(), 0, 4 ), self::$allPrefixes['multilinks'] ) );
	}

	public function isVisafone() {
		return ( in_array( substr( $this->formatted(), 0, 5 ), self::$allPrefixes['visafone'] )
		         || in_array( substr( $this->formatted(), 0, 4 ), self::$allPrefixes['visafone'] ) );
	}

	public function isNtel() {
		return ( in_array( substr( $this->formatted(), 0, 4 ), self::$allPrefixes['multilinks'] ) );
	}

	public function isStarcomms() {
		return ( in_array( substr( $this->formatted(), 0, 5 ), self::$allPrefixes['starcomms'] )
		         || in_array( substr( $this->formatted(), 0, 4 ), self::$allPrefixes['starcomms'] ) );
	}

	public function isZoom() {
		return ( in_array( substr( $this->formatted(), 0, 4 ), self::$allPrefixes['zoom'] ) );
	}

	public function getPrefixesByNetwork( $network ) {
		if ( array_key_exists( $network, self::$allPrefixes ) ) {
			return self::$allPrefixes[ $network ];
		}

		return [];
	}

	public function getNetworkByPrefix( $area ) {
		foreach (self::$allPrefixes as $key => $value ) {
			if (in_array($area, $value))
				return $key;
		}

		return null;
	}

	public function getAreaCodeByName( $area ) {
		foreach ( self::$allAreaCodes as $key => $value ) {
			if ( $key == $area ) {
				return $value;
			}
		}

		return null;
	}
}

