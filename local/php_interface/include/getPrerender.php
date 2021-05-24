<?
$bot_detected = preg_match('/bot|crawl|slurp|spider|googlebot|yandex/i', $_SERVER['HTTP_USER_AGENT']);
if($bot_detected){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://service.prerender.io/https://megratec.ru".$_SERVER['REQUEST_URI']);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'X-Prerender-Token: HrjSuplBIe7WaRPXnywL'
	));

	$response     = curl_exec($ch);
	$responseInfo = curl_getinfo($ch);
	$headerSize   = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
	curl_close($ch);

	$responseHeaders = substr($response, 0, $headerSize);
	$responseBody    = substr($response, $headerSize);

	print_r($responseBody);
	exit;
}

?>