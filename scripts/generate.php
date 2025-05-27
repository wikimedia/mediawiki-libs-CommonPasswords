<?php

if ( PHP_SAPI !== 'cli' ) {
	die( "Run me from the command line please.\n" );
}

$inputFileName = __DIR__ . '/data/10_million_password_list_top_100000.txt';
$outputFileName = __DIR__ . '/../data/common.php';

if ( !file_exists( $inputFileName ) ) {
	echo "{$inputFileName} doesn't exist\n";
	exit( 1 );
}

$file = fopen( $inputFileName, 'r' );

if ( !$file ) {
	echo "Cannot open {$inputFileName}\n";
	exit( 1 );
}

$code = "<?php return [\n";
while ( !feof( $file ) ) {
	$line = trim( fgets( $file ) );
	if ( !$line ) {
		continue;
	}
	$code .= var_export( $line, true ) . " => 1,\n";
}
fclose( $file );
$code .= "\n];\n";

file_put_contents( $outputFileName, $code );

echo "Created " . basename( $outputFileName ) . "\n";
