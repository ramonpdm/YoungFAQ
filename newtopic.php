<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") { //Comprobamos que hemos recibido una solicitud POST.
	include_once('core/init.php');

	$topic = new Topic();

	if (isset($_SESSION['user']) || isset($_POST['title']) || isset($_POST['content'])) {
		$id_user = $_SESSION['user'];
		$title = $_POST['title'];
		$category = $_POST['category'];
		$content = $_POST['content'];

		try {
			$topic->newTopic(
				array(
					'id_user' 	=> $id_user,
					'title' 	=> $title,
					'content' 	=> $content,
					'comments' 	=> 0,
					'views' 	=> 0,
					'status'	=> 'pending'
				),
				array(
					'id_topic'	=> $topic->$insert_id,
					'name'		=> $category
				)
			);

			echo  '<div class="alert alert-success text-center">' . PHP_EOL;
			echo  '<span>La publicación se creó con éxito.</span>' . PHP_EOL;
			echo  '</div>' . PHP_EOL;
		} catch (Exception $e) {
			echo  '<div class="alert alert-danger text-center">' . PHP_EOL;
			echo  '<span>' . $e->getTraceAsString(), '</span>' . PHP_EOL;
			echo  '</div>' . PHP_EOL;
		}
	}
}
