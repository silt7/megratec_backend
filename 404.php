<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$arrUri = [
			'dizayn-centr', 'products', 'contacts',
			'trainings', 'about', 'news',
			'ic_services', 'pcb_services'
		  ];

$check404 = true;

if($_SERVER['REQUEST_URI'] == ''){
	$check404 = false;
}

foreach ($arrUri as $item){
	if(($_SERVER['REQUEST_URI'] == '/'.$item)
	   ||($_SERVER['REQUEST_URI'] == '/'.$item.'/')){
			$check404 = false;
			break;
	}
}

$request_uri = explode('/' , $_SERVER['REQUEST_URI']);

if(isset($request_uri[2])){
	CModule::IncludeModule("iblock");
	if($request_uri[1] == 'news'){
		$request_uri[1] = 'new';
	}

	$element = CIBlockElement::getList(
					["SORT" => "ASC"], 
					[
						"ACTIVE" => "Y",
						"IBLOCK_CODE" => $request_uri[1].'s',
						"CODE" => $request_uri[2]
					], 
					false, 
					false,
					['CODE']
				)->fetch();
	if(!empty($element)){
		$check404 = false;
	}
}

if ($check404){
	$APPLICATION->RestartBuffer();
	CHTTP::SetStatus("404 Not Found");
	@define("ERROR_404","Y");

	$APPLICATION->SetTitle("404 Not Found");
?>
	<html>
		<head>
			<title>Страница не найдена</title>
			<meta name="description" content="404 страница не существует">
			<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
			<style>
				body{
					font-family: Montserrat;
					font-size: 1rem;
					line-height: 1.7;
					color: #525f7f;
					background-color: #fff;
				}
				a{
					text-decoration: none;
				}
			</style>
		</head>
		<body>
			<p style="text-align: center; margin-top: 15%;">
			<span style="font-size: 36px; font-weight:bold;">404</span><br>
			<span style="font-size: 34px;">Страница не найдена</span>
			<br><a href="/">Вернуться на главную</a></p>
		</body>
	</html>

<?	die();
}

?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>