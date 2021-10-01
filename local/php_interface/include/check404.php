<?
    $sections = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/sections.json');
	$arrUri = json_decode($sections);
	
    $GLOBALS['check404'] = true;
    
    if($_SERVER['REQUEST_URI'] == '' or $_SERVER['REQUEST_URI'] == '/'){
    	$GLOBALS['check404'] = false;
    }
    
    foreach ($arrUri as $item){
    	if(($_SERVER['REQUEST_URI'] == '/'.$item)
    	   ||($_SERVER['REQUEST_URI'] == '/'.$item.'/')){
    			$GLOBALS['check404'] = false;
    			break;
    	}
    }
    
    $request_uri = explode('/' , $_SERVER['REQUEST_URI']);
    
    if(isset($request_uri[2])){
    	CModule::IncludeModule("iblock");
    	
    	$ibloc_code = $request_uri[1];
    	$filter = [
			"ACTIVE" => "Y",
			"IBLOCK_CODE" => $ibloc_code,
			"CODE" => $request_uri[2]
    	];
    	
        if($request_uri[1] != 'news'){
            $filter["IBLOCK_CODE"] = $ibloc_code.'s';
        }
        
    	if($request_uri[1] == 'training'){
    	   $filter["IBLOCK_CODE"] = 'pages';
    	   $filter["SECTION_ID"] = 18;
    	}
    	
    	$element = CIBlockElement::getList(
    					["SORT" => "ASC"], 
    					$filter, 
    					false, 
    					false,
    					['CODE']
    				)->fetch();
    	
    	if(!empty($element)){
    		$GLOBALS['check404'] = false;
    	}
    }
    
    if(isset($request_uri[3])){
        $GLOBALS['check404'] = true;
    }
?>