<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
global $USER; 
if ($USER->IsAdmin()){
	delTree('css');
	delTree('fonts');
	delTree('img');
	delTree('js');
	unlink("index.html");
	$zip = new ZipArchive;
	$res = $zip->open('dist.zip');
	if ($res === TRUE) {
		$zip->extractTo('../megratec');
	  $zip->close();
	  echo 'ok';
	} else {
	  echo 'failed';
	}
	$index = file_get_contents('index.html');
	$index = str_replace('<!DOCTYPE html><html lang=en><head>', '', $index);
	$index = str_replace('</body></html>', '', $index);
	//print_r($index);
	file_put_contents('index.html', $index); 
	unlink("dist.zip");
} else {
	echo 'Не авторизован';	
}
function delTree($dir) {
   $files = array_diff(scandir($dir), array('.','..'));
    foreach ($files as $file) {
      (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
    }
    return rmdir($dir);
}
?>