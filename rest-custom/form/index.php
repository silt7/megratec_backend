<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$APPLICATION->SetTitle("Форма");
CModule::IncludeModule("iblock");

$email = 'support@megtatec.ru';
//$email = 'silt777@gmail.com';
$sendMail = 0;

$line = '<br>--------------------<br>';
$text = 'Имя:'.$_GET['name'].$line;
$text .= 'Компания: '.$_GET['company'].$line;
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
	$data['UF_NAME'] = $_GET['name'].' Компания: '.$_GET['company'];
	$data['UF_EMAIL'] = $_GET['email'];
	$data['UF_MESS'] = $_GET['comment'].'| Телефон: '.$_GET['phone'];
	$data['UF_DATE'] = $dt;

	$result = $entity_data_class::add($data);
}


/*************Bitrix CRM *****************/
	$comment = $_GET['comment'].' | ';
	$comment .= 'Источник: https://megrateс.ru'.$_GET['source'];
	$queryUrl = 'https://cadflo.bitrix24.ru/rest/9/ylcxpo47n8re735w/crm.lead.add.json';
	$queryData = [
				'fields' => array(
					 "STATUS_ID" => "4",
					 "TITLE" => $_GET['name'].' Компания: '.$_GET['company'],
					 "NAME" => $_GET['name'],
					 "PHONE" => array(array("VALUE" => $_GET['phone'], "VALUE_TYPE" => "WORK" )),
				     "EMAIL" => array(array("VALUE" => $_GET['email'], "VALUE_TYPE" => "WORK" )),
					 "UF_CRM_1589450282041" => $comment
				),
				'params' => array("REGISTER_SONET_EVENT" => "Y")
			];

	$queryData = http_build_query($queryData);

	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_SSL_VERIFYPEER => 0,
		CURLOPT_POST => 1,
		CURLOPT_HEADER => 0,
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => $queryUrl,
		CURLOPT_POSTFIELDS => $queryData,
	));

	$result = curl_exec($curl);
	curl_close($curl);

	$result = json_decode($result, 1);

	if (array_key_exists('error', $result)) return "Ошибка: ".$result['error_description']."<br/>";
	 else return $result;
?>