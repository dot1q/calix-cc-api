<?php

/**
 * Calix CC API
 *
 *
 * @package    Fiber Management System
 * @author     Gregory Brewster <gbrewster@agoasite.com>
 * @copyright  (C)2016 City of Sandy
 *
 */

include_once("../config.php");

// CC is case sensitive for serial numbers!
$serno = strtoupper($_GET['serno']);

if(strlen($serno) == 6){
	$serialNumber = 'CXNK00'.$serno;
} else {
	$serialNumber = $serno;
}

$header_options = array(
  'http'=>array(
    'method'=>"GET",
    'header'=>"Authorization: Basic " . base64_encode($config['cc-username'].":".$config['cc-password'])." \r\n"
  )
);

$context = stream_context_create($header_options);

// Open the file using the HTTP headers set above
$file = file_get_contents($config['cc-host-uri'].'/api/device?serialNumber='.$serialNumber, false, $context);


// Two types of outputs
print $file;

// or decode to PHP object
print_r(json_decode($file));
?>

