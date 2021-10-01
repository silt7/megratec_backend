<?
AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", Array("UpdateIblock", "OnBeforeIBlockElementUpdateHandler"));
class UpdateIblock
{
    function OnBeforeIBlockElementUpdateHandler(&$arFields)
    {
        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/last-modified.txt', gmdate('D, d M Y H:i:s'));
    }
}