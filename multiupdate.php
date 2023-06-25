<?php
// EDIT HERE FOR YOUR NEEDS
// Provide here the URL you want to use for recognition of external IPv4/6 address. Any internet address outside your local network should do.
$sCurlURL = "https://www.google.com";

// Make sure the request comes from the NAS itself. Default Web Station runs with nginx without auth support, so this adds some security to the script.
$bSec = False; // Enable this security feature
$sOwnIP = "192.168.178.2"; // NAS IP

if($_SERVER["REMOTE_ADDR"] != $sOwnIP && $bSec == True) {
	http_response_code(401);
	die();
}

// Include the CURL query as function
include("query.php");

// The pipes "|" are used as delimiters for each url query
// The urls are passed to a field.
// Sometimes the pipes get converted to "%7C" during the transfer, so we need to convert that back.
$aQuery = explode("|", str_replace("%7C", "|", $_SERVER["QUERY_STRING"]));

$sIP = "";

// Checking on each url whether it ends with a "=". The first one will execute a CURL query and obtains own IPv6 which is added to the url.
// All following url can omit the the query, because we already have this information stored.
foreach($aQuery as $sQuery){
	if(substr($sQuery,-1) == "="){
		if($sIP == ""){
			$sIP = ip_query($sCurlURL);
		}
		$sQuery = $sQuery . $sIP;
	}
	file_get_contents($sQuery);
}
echo "Good";

?>