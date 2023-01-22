<?php

require_once dirname( __DIR__ ) . '/src/CommonPasswords.php';
require_once dirname( __DIR__ ) . '/vendor/autoload.php';

use Wikimedia\CommonPasswords\CommonPasswords;

echo "PHP " . PHP_VERSION . "\n";

$t = microtime( true );
CommonPasswords::getFilter();
$t = round( microtime( true ) - $t, 6 ) * 1000;
echo "Load bloom filter: {$t}ms\n";

$passwords = [
	'password' => true,
	'testwikijenkinspass' => false,
];

foreach ( $passwords as $p => $v ) {
	$t = microtime( true );
	$isCommon = CommonPasswords::isCommon( $p );
	$t = round( microtime( true ) - $t, 6 ) * 1000;
	if ( $isCommon ) {
		echo "Time to check a password that is in the filter: {$t}ms\n";
	} else {
		echo "Time to check a password that is not in the filter: {$t}ms\n";
	}
}
