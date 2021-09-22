<?php
	session_start();
	session_destroy();

	if (isset($_GET['from']) || !empty($_GET['from']) || $_GET['from'] != ""){
		$to = filter_var($_GET['from'], FILTER_SANITIZE_URL);
		header('location:'.$to);
	}else{
		header('location:/');
	}

	
?>