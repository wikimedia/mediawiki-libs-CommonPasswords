<?php
declare( strict_types = 1 );

namespace Wikimedia\CommonPasswords;

class CommonPasswords {

	/**
	 * @internal
	 */
	public static function getData(): array {
		static $data = null;
		if ( $data === null ) {
			$data = require __DIR__ . '/../data/common.php';
		}
		return $data;
	}

	/**
	 * Check if a given password is considered common
	 */
	public static function isCommon( string $password ): bool {
		return isset( self::getData()[ $password ] );
	}
}
