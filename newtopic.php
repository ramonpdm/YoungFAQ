<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	include_once('core/init.php');
	$topic = new Topic();
	if (isset($_POST['title'])) {
		$id_user = $_SESSION['user'];
		$title = $_POST['title'];
		$category = $_POST['category'];
		$content = $_POST['content'];

		try {
			$topic->insert('topics', array(
				'id_user' 	=> $id_user,
				'title' 	=> $title,
				'content' 	=> $content,
				'comments' 	=> 0,
				'views' 	=> 0,
				'status'	=> 'pending'
			));

			echo  '<div class="alert alert-success text-center">'.PHP_EOL;
			echo  '<span>La publicación se creó con éxito.</span>'.PHP_EOL;
			echo  '</div>'.PHP_EOL;
		} catch (Exception $e) {
			echo  '<div class="alert alert-danger text-center">'.PHP_EOL;
			echo  '<span>' . $e->getTraceAsString(), '</span>'.PHP_EOL;
			echo  '</div>'.PHP_EOL;
		}
	}
}
