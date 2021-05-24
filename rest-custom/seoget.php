<?
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
    
    CModule::IncludeModule("iblock");

	$element = CIBlockElement::GetList([], ['CODE' => $_GET['CODE']])->fetch();

    $ipropValues = new \Bitrix\Iblock\InheritedProperty\ElementValues($element['IBLOCK_ID'], $element['ID']);
	$arResult = $ipropValues->getValues();

    echo json_encode($arResult, JSON_UNESCAPED_UNICODE);
?>