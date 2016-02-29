<?php require dirname(__DIR__) . '/vendor/autoload.php';

/**
 * Use the external piwik devide detector lib
 */
use Pete001\Agent\DeviceDetectorAdaptor;

$agent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.116 Safari/537.36';
$domain = new DeviceDetectorAdaptor($agent);

// All supported methods
print_r([
	$domain->isDesktop(),
	$domain->isMobile(),
	$domain->isMobileApp(),
	$domain->isBot()
]);
