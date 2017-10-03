<?php

namespace Wikimedia\PasswordBlacklist;

use Pleo\BloomFilter\BloomFilter;

class PasswordBlacklist {

	/**
	 * @return BloomFilter
	 */
	private static function getFilter() {
		static $filter = null;
		if ( $filter === null ) {
			$filter = BloomFilter::initFromJson(
				json_decode( file_get_contents( __DIR__ . '/blacklist.json' ), true )
			);
		}
		return $filter;
	}

	/**
	 * @param string $password Password to check if in the Bloom Filter
	 * @return bool
	 */
	public static function isBlacklisted( $password ) {
		return self::getFilter()->exists( $password );
	}
}
