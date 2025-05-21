<?php

$cfg = require __DIR__ . '/../vendor/mediawiki/mediawiki-phan-config/src/config-library.php';

$cfg['exclude_file_list'] = array_merge(
	$cfg['exclude_file_list'],
	[
		// T394821
		'src/common.php',
	]
);

return $cfg;
