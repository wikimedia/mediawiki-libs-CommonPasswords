<?php

require_once dirname( __DIR__ ) . '/src/CommonPasswords.php';

use Wikimedia\CommonPasswords\CommonPasswords;

echo "PHP " . PHP_VERSION . " " . ( PHP_INT_SIZE === 8 ? "x64" : "x86" ) . "\n";

$t = microtime( true );
CommonPasswords::getData();
$t = round( microtime( true ) - $t, 6 ) * 1000;
echo "Load dataset: {$t}ms\n";

$passwords = [
	'password' => true,
	'testwikijenkinspass' => false,
];

foreach ( $passwords as $p => $v ) {
	$t = microtime( true );
	$isCommon = CommonPasswords::isCommon( $p );
	$t = round( microtime( true ) - $t, 6 ) * 1000;
	if ( $isCommon ) {
		echo "Check a password in the dataset: {$t}ms\n";
	} else {
		echo "Check a password not in the dataset: {$t}ms\n";
	}
}
