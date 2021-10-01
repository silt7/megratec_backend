<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

if ($GLOBALS['check404']){
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

<?	
	die();
}

?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>