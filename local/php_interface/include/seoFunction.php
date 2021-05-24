<?
if (\Bitrix\Main\Loader::includeModule('iblock'))
{
	\Bitrix\Main\EventManager::getInstance()->addEventHandler(
		"iblock",
		"OnTemplateGetFunctionClass",
		"seoTemplatesHandler"
	);

	function seoTemplatesHandler(Bitrix\Main\Event $event) {
		$arParam = $event->getParameters();
		$functionClass = $arParam[0];
		if(is_string($functionClass) && class_exists($functionClass)){
			switch ($functionClass){
				case 'del_html_tag': // удаление html тегов
					$result = new Bitrix\Main\EventResult(1,$functionClass);
					break;
			}
		}

		return $result;
	}

	//подключаем файл с определением класса FunctionBase
	//это пока требуется т.к. класс не описан в правилах автозагрузки
	include_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/iblock/lib/template/functions/fabric.php");

	class del_html_tag extends \Bitrix\Iblock\Template\Functions\FunctionBase
	{
		public function onPrepareParameters(\Bitrix\Iblock\Template\Entity\Base $entity, $parameters)
		{
			$arguments = array();
			/** @var \Bitrix\Iblock\Template\NodeBase $parameter */
			foreach ($parameters as $parameter)
			{
				$arguments[] = $parameter->process($entity);
			}
			return $arguments;
		}

		public function calculate(array $parameters)
		{
			foreach ($parameters as $key => $parameter)
			{
				$parameters[$key] = strip_tags($parameter);
				$parameters[$key] = preg_replace("/(\t+)/is","",$parameters[$key]);//вырезать табуляции
				$parameters[$key] = preg_replace("/(\s+){2,}/is"," ",$parameters[$key]);//заменить двойные пробелы одинарными
				$parameters[$key] = preg_replace("/(\r\n)+/i", "", $parameters[$key]);//удалить переводы строки
			}
			if(isset($parameters[0]) && $parameters[0] && isset($parameters[1])) {
				return sprintf(mb_substr($parameters[1],$parameters[0],0,250));
			} else {
				return sprintf(mb_substr($parameters[0],0,250));
			}
      		return "";
		}
	}
}
?>