<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") { //Comprobamos que hemos recibido una solicitud POST.
	include_once('../init.php');

	$topic = new Topic();

	if (isset($_SESSION['user'])) {
		$id_user = $_SESSION['user'];
		$id_topic = $_POST['id_topic'];
		$content = $_POST['commentContent'];

		try {
			$topic->insertData(
				'comment',
				array(
					'id_topic'  => $id_topic, 
					'id_user' 	=> $id_user,
					'content' 	=> $content,
					'status'	=> 'published'
				)
			);

			echo  '<div class="alert alert-success text-center">' . PHP_EOL;
			echo  '<span>El comentario se publicó con éxito.</span>' . PHP_EOL;
			echo  '</div>' . PHP_EOL;
		} catch (Exception $e) {
			echo  '<div class="alert alert-danger text-center">' . PHP_EOL;
			echo  '<span>' . $e->getTraceAsString(), '</span>' . PHP_EOL;
			echo  '</div>' . PHP_EOL;
		}
	}
}
