<?php
//This function is more or less a copy from https://dns.hetzner.com/api-docs 
function ip_query($sURL = "https://www.google.com") {

// Start a HTTP request outside of the local network via cURL to obtain the external IPv6 address

// get cURL resource
$ch = curl_init();

// set url
curl_setopt($ch, CURLOPT_URL, $sURL);

// return the transfer as a string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// set method
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

// set a IPv6 query

curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V6);

// send the request and save response to $response
$response = curl_exec($ch);

// stop if fails
if (!$response) {
	die('Error IP check: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
}

// get own IP address
$response = curl_getinfo($ch, CURLINFO_LOCAL_IP);

// close curl resource to free up system resources 
curl_close($ch);

return $response;
}
?>