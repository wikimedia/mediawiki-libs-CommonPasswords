<?php

namespace Wikimedia\CommonPasswords\Test;

use Wikimedia\CommonPasswords\CommonPasswords;

/**
 * @covers \Wikimedia\CommonPasswords\CommonPasswords
 */
class CommonPasswordsTest extends \PHPUnit\Framework\TestCase {

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
	 * Tests that all the passwords in the original 10_million_password_list_top_100000.txt file
	 * are in the BloomFilter.
	 *
	 * @param string $password
	 */
	function testCommonPasswords() {
		// We don't use a data provider here to avoid creating 100,000 test cases.
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
	function testNotCommonPasswords( $password ) {
		$this->assertFalse( CommonPasswords::isCommon( $password ) );
	}
}
