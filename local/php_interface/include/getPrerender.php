<?
$bot_detected = preg_match('/bot|crawl|slurp|spider|googlebot|yandex/i', $_SERVER['HTTP_USER_AGENT']);

$folder = ['personal', 'forum', 'auth'];

$bitrixFolder = false;
foreach($folder as $item){
	//$string = '/abdcdefghijklmnopqrstuvwxyz0123456789';
	if(preg_match("/^\/$item/", $_SERVER['REQUEST_URI'])){
		$bitrixFolder = true;
	}
}

if($bot_detected && ( $GLOBALS['check404'] === false)&& ( $bitrixFolder === false)){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://service.prerender.io/https://megratec.ru".$_SERVER['REQUEST_URI']);
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
	
	/************* lastModified ********************/
	$lastModified = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/last-modified.txt');
	$IfModifiedSince = false;
    if (isset($_ENV['HTTP_IF_MODIFIED_SINCE']))
     $IfModifiedSince = strtotime(substr($_ENV['HTTP_IF_MODIFIED_SINCE'], 5)); 
    if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']))
     $IfModifiedSince = strtotime(substr($_SERVER['HTTP_IF_MODIFIED_SINCE'], 5));
    if ($IfModifiedSince && $IfModifiedSince >= $LastModified_unix) {
     header($_SERVER['SERVER_PROTOCOL'] . ' 304 Not Modified');
     exit;
    }
    /*************END lastModified ********************/
    header('Last-Modified: '.$lastModified. ' GMT');
    
	print_r($responseBody);
	exit;
	die;
}

?>