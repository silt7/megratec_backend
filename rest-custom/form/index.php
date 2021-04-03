<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$APPLICATION->SetTitle("Форма");
CModule::IncludeModule("iblock");

//$email = 'support@megtatec.ru';
$email = 'silt777@gmail.com';
$sendMail = 0;

$line = '<br>--------------------<br>';
$text = 'Имя:'.$_GET['name'].$line;
$text .= 'Телефон:'.$_GET['phone'].$line;
$text .= 'Email:'.$_GET['email'].$line;
$text .= 'Комментарий:'.$_GET['comment'];

$arFields = [
        'IBLOCK_ID' => 6,
        'NAME' => $_GET['name'],
        "DETAIL_TEXT" => $text
    ];

if($_GET['form'] == 'callme'){
    $messTitle = 'Форма Связаться';
    $arFields['IBLOCK_SECTION'] = 15;
}

if($_GET['form'] == 'training'){
    $messTitle = 'Записаться на обучение';
    $arFields['IBLOCK_SECTION'] = 14;
}

$el = new CIBlockElement;
if($el->Add($arFields)){
  echo json_encode("success", JSON_UNESCAPED_UNICODE);
  $sendMail = 1;
} else {
  echo json_encode("Error: ".$el->LAST_ERROR, JSON_UNESCAPED_UNICODE);
}


if($sendMail == 1){
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
    $headers .= 'From: Megratec <info@megratec.ru>' . "\r\n";
    mail($email, $messTitle, $text, $headers);
}



use Bitrix\Main\Loader; 

Loader::includeModule("highloadblock"); 

use Bitrix\Highloadblock as HL; 
use Bitrix\Main\Entity;
use Bitrix\Main\Type\DateTime;

$hlblock = HL\HighloadBlockTable::getById(1)->fetch(); 

$entity = HL\HighloadBlockTable::compileEntity($hlblock); 
$entity_data_class = $entity->getDataClass(); 

$data = [];
if(($_GET['name'] != '')and($_GET['email'] != '')){
	$dt = new DateTime();
	$data['UF_TITLE'] = 'Заявка';
	$data['UF_NAME'] = $_GET['name'];
	$data['UF_EMAIL'] = $_GET['email'];
	$data['UF_MESS'] = $_GET['comment'];
	$data['UF_DATE'] = $dt;

	$result = $entity_data_class::add($data);
}
?>