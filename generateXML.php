<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");

$dom = new DOMDocument('1.0', 'utf-8');
$urlset = $dom->createElement('urlset');
$urlset->setAttribute('xmlns','http://www.sitemaps.org/schemas/sitemap/0.9');

$routes = ["/", "/products", "/dizayn-centr", "/trainings", "/contacts", "/about"];

$routes = getIDs($routes, 'products', '/product/'); 
$routes = getIDs($routes, 'news', '/news/');

print_r($routes);
foreach($routes as $uri){
	$url = $dom->createElement('url');
 
	// Элемент <loc> - URL статьи.
	$loc = $dom->createElement('loc');
	$text = $dom->createTextNode(
		htmlentities('https://'.$_SERVER['HTTP_HOST'].$uri, ENT_QUOTES)
	);
	$loc->appendChild($text);
	$url->appendChild($loc);

	// Элемент <priority> 
	$priority = $dom->createElement('priority');
	$text = $dom->createTextNode(1);
	$priority->appendChild($text);
	$url->appendChild($priority);

	$urlset->appendChild($url);
}

$dom->appendChild($urlset);
// Сохранение в файл.
$dom->save($_SERVER["DOCUMENT_ROOT"].'/sitemap.xml');

function getIDs($routes, $entity, $link){
	$elements = CIBlockElement::getList([], ['IBLOCK_CODE' => $entity, 'ACTIVE' => 'Y'], false, false, ['ID', 'CODE']);
	while ($element = $elements->GetNext()) {
		if(!empty($element['CODE'])){
			array_push($routes, $link.$element['CODE']);
		} else {
			array_push($routes, $link.$element['ID']);
		}
	}

	return $routes;
}