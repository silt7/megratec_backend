<?
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
    
    CModule::IncludeModule("iblock");
    $entity = isset($_GET['ENTITY'])?$_GET['ENTITY']:'';
    $arResult['result'] = [];
    
    
    $arOrder = ["SORT"=>"ASC"];
    $arFilter = [        
        "IBLOCK_CODE"=>$entity,
        "ACTIVE"=>"Y"
    ];
    $arGroupBy = false;
    $arNavStartParams = false;
    $arSelectFields = ['ID', '*'];
    
    if ($entity == "banners") {
        $arFilter["IBLOCK_CODE"] ="pages";
        $arFilter["SECTION_ID"] = "13";
    }
    
    $dbRes = CIBlockElement::GetList(
      $arOrder,
      $arFilter,
      $arGroupBy,
      $arNavStartParams,
      $arSelectFields
    );
    
    while($element = $dbRes->GetNext())
    {
        $propsDbres = CIBlockElement::GetProperty($element['IBLOCK_ID'], $element['ID'], "sort", "asc", array(">ID" => 1));
    
        $i = 0;
        while ($prop = $propsDbres->GetNext()) {
          $i = !isset($element['PROPERTY_VALUES'][$prop['CODE']]) ? 0 : $i+1;
          $element['PROPERTY_VALUES'][$prop['CODE']]['NAME'] = $prop['NAME'];
          $element['PROPERTY_VALUES'][$prop['CODE']]['TYPE'] = $prop['PROPERTY_TYPE'];
          $element['PROPERTY_VALUES'][$prop['CODE']]['ACTIVE'] = $prop['ACTIVE'];
        
          $element['PROPERTY_VALUES'][$prop['CODE']]['VALUES'][$i] = [
             'VALUE' => $prop['VALUE'],
             'DESCRIPTION' => $prop['DESCRIPTION'],
          ];
        
          if ($prop['PROPERTY_TYPE'] == 'F')
             $element['PROPERTY_VALUES'][$prop['CODE']]['VALUE'][$i]['PATH'] = \CFile::GetPath(intval($prop['VALUE']));
        }
        array_push($arResult['result'], $element);
    }

    echo json_encode($arResult, JSON_UNESCAPED_UNICODE);
?>