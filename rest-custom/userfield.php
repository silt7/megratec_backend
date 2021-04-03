<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$APPLICATION->SetTitle("Продукты");

CModule::IncludeModule("iblock");
if(($_GET['IBLOCK']) && ($_GET['ID'])){
	$rsSections = CIBlockSection::GetList(
	   array(), 
	   array(
		  "IBLOCK_ID" => $_GET['IBLOCK'],
		  "ID" => $_GET['ID']
	   ), 
	   true, 
	   array("ID", "DEPTH_LEVEL", "SECTION_PAGE_URL", "UF_*")
	);
	echo json_encode($rsSections->fetch(), JSON_UNESCAPED_UNICODE);
}
?>