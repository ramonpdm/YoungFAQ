<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") { //Comprobamos que hemos recibido una solicitud POST.
	include_once('../init.php');

	$topic = new Topic();
	$user = new User();

	if (isset($_SESSION['user']) || isset($_POST['title']) || isset($_POST['content'])) {
		$id_user = $_SESSION['user'];
		$title = $_POST['title'];
		$category = $_POST['category'];
		$content = $_POST['content'];

		if ($user->isAdmin($id_user)){
			$status = "published";
		}else{
			$status = "pending";
		}

		try {
			$topic->insertData(
				'topic',
				array(
					'id'		=> $topic->nextID(), 
					'id_user' 	=> $id_user,
					'title' 	=> $title,
					'content' 	=> $content,
					'comments' 	=> 0,
					'views' 	=> 0,
					'status'	=> $status
				),
				array(
					'id_topic'	=> $topic->nextID(),
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
