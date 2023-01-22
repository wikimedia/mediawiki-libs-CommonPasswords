<?php

namespace Wikimedia\CommonPasswords\Test;

use PHPUnit\Framework\TestCase;
use Wikimedia\CommonPasswords\CommonPasswords;

/**
 * @covers \Wikimedia\CommonPasswords\CommonPasswords
 */
class CommonPasswordsTest extends TestCase {

	public static function getCommonPasswords() {
		$lines = [];
		$file = fopen(
			dirname( __DIR__ ) . '/scripts/data/10_million_password_list_top_100000.txt',
			'r'
		);
		while ( !feof( $file ) ) {
			$line = trim( fgets( $file ) );
			if ( !$line ) {
				continue;
			}
			$lines[] = $line;
		}

		return $lines;
	}

	/**
	 * Confirm presence of all passwords in the original 10_million_password_list_top_100000.txt file.
	 */
	public function testCommonPasswords() {
		// We don't use a data provider here to avoid creating many test cases.
		foreach ( self::getCommonPasswords() as $password ) {
			$this->assertTrue( CommonPasswords::isCommon( $password ) );
		}
	}

	public static function getNotCommonPasswords() {
		return [
			[ 'testwikijenkinspass' ],
			[ 'MediaWiki' ],
			[ 'Wikipedia' ],
			[ 'Wikimedia' ],

			// Passwords that are known to have been false positives
			[ 'yell0w lighter peeler' ],
		];
	}

	/**
	 * Tests a few passwords that aren't in the common list
	 *
	 * @dataProvider getNotCommonPasswords
	 * @param string $password
	 */
	public function testNotCommonPasswords( $password ) {
		$this->assertFalse( CommonPasswords::isCommon( $password ) );
	}
}
