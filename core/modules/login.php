<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	session_start();
	include_once('../init.php');

	$user = new User();

	if (isset($_POST['username'])) {
		$username = $user->escape_string($_POST['username']);
		$password = $user->escape_string($_POST['password']);

		$auth = $user->checkLogin($username, $password);

		if (!$auth) { ?>
			<div class="alert alert-danger text-center">
				<span>Usuario o contraseña no encontrado. Intente nuevamente.</span>
			</div>
<?php } else {
			$_SESSION['user'] = $auth;
		}
	} else {
		header('location: /');
	}
}

?>