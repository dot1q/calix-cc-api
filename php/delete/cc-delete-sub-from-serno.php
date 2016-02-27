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


$serno = $_GET['serno'];

if(strlen($serno) == 6){
	$serialNumber = 'CXNK00'.$serno;
} else {
	$serialNumber = $serno;
}


$cc_id = pull_cc_id($config, $serialNumber);
delete_sub_entry($config, $cc_id);

/*
 * Deletes the subscriber entry
 * @params $config is the configuration array, $cc_id is the consumer connect record id
 * @return none
 */
 
function delete_sub_entry($config, $cc_id){
	$header_options = array(
	  'http'=>array(
		'method'=>"DELETE",
		'header'=>"Authorization: Basic " . base64_encode($config['cc-username'].":".$config['cc-password'])." \r\n"
	  )
	);

	$context = stream_context_create($header_options);

	// Open the file using the HTTP headers set above
	$file = file_get_contents($config['cc-host-uri'].'/api/device/'.$cc_id, false, $context);

}


/*
 * Pull consumer connect record id
 * @params: $config is the configuration array, $serialNumber is the FSAN of the ONT
 * @return: the consumer connect subscriber record
 */ 
function pull_cc_id($config, $serialNumber){

	$header_options = array(
	  'http'=>array(
		'method'=>"GET",
		'header'=>"Authorization: Basic " . base64_encode($config['cc-username'].":".$config['cc-password'])." \r\n"
	  )
	);

	$context = stream_context_create($header_options);

	// Open the file using the HTTP headers set above
	$file = file_get_contents($config['cc-host-uri'].'/api/device?serialNumber='.$serialNumber, false, $context);

	return json_decode($file)->_id;
}

?>

