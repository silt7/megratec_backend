<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$APPLICATION->SetTitle("Поиск");
CModule::IncludeModule('search');
CModule::IncludeModule("iblock");
$obSearch = new CSearch;
$obSearch->Search(array(
  'QUERY' => $_REQUEST['q'],
  'SITE_ID' => 's1',
  'MODULE_ID' => 'iblock',
));
$obSearch->NavStart();
$resultArr = [];
while ($arSearch = $obSearch->Fetch()) {
    $arSearch['BODY_FORMATED'] = strip_tags($arSearch['BODY_FORMATED']);
    $element = CIBlockElement::GetByID($arSearch['ITEM_ID'])->fetch();
    if($element['IBLOCK_ID'] == 3){
        $arSearch['URL'] = 'product/'.$arSearch['ITEM_ID'];
    } else if($element['IBLOCK_ID'] == 4){
        $arSearch['URL'] = 'new/'.$arSearch['ITEM_ID'];
    } else {
        $arSearch['URL'] = $element['CODE'];
    }
    
    array_push($resultArr, $arSearch);
}
echo json_encode($resultArr, JSON_UNESCAPED_UNICODE);
?>