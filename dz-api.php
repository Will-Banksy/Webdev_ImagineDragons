<?php

$url = "https://api.deezer.com".$_GET["dz-endpoint"];

if ($url) { // If url is specified
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	// Set so curl_exec returns the result instead of outputting it.
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// Get the response and close the channel.
	$response = curl_exec($ch);
	curl_close($ch);

	echo $response;
}

?>