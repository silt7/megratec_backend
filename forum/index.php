<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

?>

<?
$dbh = new PDO('mysql:host=localhost;dbname=megratec_bitrix', 'megratec_bitrix', 'mfGNNCH9');
$result = $dbh->query('SELECT * from old_forum_forums');
?>
<ul class="forum-content">
	<?
	$n = 0;
	if( is_null($_GET['section']) && is_null($_GET['topic']) && is_null($_GET['post']) ){
		$APPLICATION->SetTitle("Форум");
		$APPLICATION->SetPageProperty("description",  "Все разделы форума");
		foreach($dbh->query('SELECT * from old_forum_forums ORDER BY id asc') as $row){
			$n++;
			echo "<li class='forum-{$n}'><a href='/forum/{$row['slug']}'>{$row['name']}</a></li>";
		}
	}
	if( !is_null($_GET['section']) && is_null($_GET['topic']) && is_null($_GET['post']) ){
		$section = $_GET['section'];
		foreach($dbh->query("SELECT * from old_forum_forums WHERE slug = '$section'") as $row){
			$section_id = $row['id'];
			$title = $row['name'];
			$description = $row['description'];
		}
		$APPLICATION->SetTitle($title);
		$APPLICATION->SetPageProperty("description",  $description);

		foreach($dbh->query('SELECT * from old_forum_topics WHERE forum_id = '.$section_id.' ORDER BY id asc') as $row){	
			$n++;
			echo "<li class='topic-{$n}'><a href='/forum/$section/{$row['slug']}'>{$row['subject']}</a></li>";
		}
		if(empty($row)){
			CHTTP::SetStatus("404 Not Found");
			@define("ERROR_404","Y");
			$APPLICATION->SetTitle("404 Not Found");
		}
	}
	if( !is_null($_GET['section']) && !is_null($_GET['topic']) && is_null($_GET['post']) ){
		$topic = $_GET['topic'];
		foreach($dbh->query("SELECT * from old_forum_topics WHERE slug = '$topic'") as $row){
			$topic_id = $row['id'];
			$title = $row['subject'];
		}
		$APPLICATION->SetTitle($title);
		$APPLICATION->SetPageProperty("description",  $title);
		foreach($dbh->query('SELECT * from old_forum_posts WHERE topic_id = '.$topic_id.' ORDER BY id asc') as $row){
			$n++;
			echo "<li class='post-{$n}'>{$row['reply_to_id']}{$row['text']}</li>";
		}
		if(empty($row)){
			CHTTP::SetStatus("404 Not Found");
			@define("ERROR_404","Y");
			$APPLICATION->SetTitle("404 Not Found");
		}
	}
	if( is_null($_GET['section']) && is_null($_GET['topic']) && !is_null($_GET['post']) ){
		$post_id = $_GET['post'];
		foreach($dbh->query('SELECT * from old_forum_posts WHERE id = '.$post_id) as $row){	
			echo "<li class='text-{$row['id']}'>{$row['text']}</li>";
			$topic_id = $row['topic_id'];
		}	
		foreach($dbh->query("SELECT * from old_forum_topics WHERE id = '$topic_id'") as $row){
			$forum_id = $row['forum_id'];
			$title = $row['subject'];
			$link_topic = $row['slug'];
		}
		$APPLICATION->SetTitle($title.'(Пост №'.$post_id.')');
		$APPLICATION->SetPageProperty("description",  'Пост №'.$post_id.'-'.$title);
		foreach($dbh->query('SELECT * from old_forum_forums WHERE id = '.$forum_id) as $row){	
			$link = $row['slug'];
		}
		echo "<a href='/forum/$link/$link_topic'>Читать полностью</a>";
		if(empty($row)){
			CHTTP::SetStatus("404 Not Found");
			@define("ERROR_404","Y");
			$APPLICATION->SetTitle("404 Not Found");
		}
	}
	?>
</ul>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>