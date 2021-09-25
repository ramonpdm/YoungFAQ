<?php
include_once('../classes/dbLink.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") { //Comprobamos que hemos recibido una solicitud POST.
	$action = $_POST['action'];
	if (isset($action)) {
		$topic = new Topic(false);
		$user = new User();

		//Aquí declaramos todas las variables (si existen) que se utilizarán en cada acción. Todas con la primera letra mayúscula (cuestión de estética).
		if (isset($_POST['id_object'])) : $id_object = $_POST['id_object'];
		endif;
		if (isset($_POST['reason'])) : $reason = ucfirst($user->cleanInputs($_POST['reason']));
		endif;
		if (isset($_POST['title'])) : $title = ucfirst($user->cleanInputs($_POST['title']));
		endif;
		if (isset($_POST['content'])) : $content = ucfirst($user->cleanInputs($_POST['content']));
		endif;
		if (isset($_POST['category'])) : $category = ucfirst($user->cleanInputs($_POST['category']));
		endif;
		if (isset($_POST['type'])) : $type = $user->cleanInputs($_POST['type']);
		endif;

		if ($user->isLogged()) { //Aquí impedimos que se realize el proceso de inicio de sesión si ya está logueado, además, establecemos el id del usuario logueado.
			$id_user = $user->isLogged(true);
		} else {
			if ($action == 'login') {
				if (isset($_POST['username']) || isset($_POST['password'])) {
					$username = $user->cleanInputs($_POST['username']);
					$password = $user->cleanInputs($_POST['password']);

					$auth = $user->checkCredencials($username, $password);

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

			if ($action == 'register') {
				if (isset($_POST['username']) || isset($_POST['fullname']) || isset($_POST['email']) || isset($_POST['password'])) {
					$username = lcfirst(str_replace(array(':', '-', '/', '*'), '', $user->cleanInputs($_POST['username']))); //No es la mejor manera de sanitizar
					$password = $user->cleanInputs($_POST['password']); //Se puede usar otros métodos para sanitizar contraseñas e indicarlo antes de procesarlo en el lado del servidor.
					$fullname = $user->cleanInputs($_POST['fullname']);
					$email = $user->cleanInputs($_POST['email']);
					$auth = $user->checkCredencials($username, $password);

					if ($auth) { ?>
						<div class="alert alert-danger text-center">
							<span>Ya el usuario ha sido utilizado, favor utilizar otro.</span>
						</div>
						<?php } else {
						if ($user->insert(
							"users",
							array(
								'username' 	=> $username,
								'name' 		=> $fullname,
								'email' 	=> $email,
								'password' 	=> $password //Sin encriptación ni nada porque entiendo que en este caso no lo amerita. De lo contrario hubiese utlizado alguna o un sistema más complejo.
							)
						)) {
						?>
							<div class="alert alert-success text-center">
								<span>El usuario <strong><?php echo $username; ?></strong> creó correctamente. Contacta a un administrador si tienes problemas para iniciar sesión.</span>
							</div>
							<script>
								setTimeout(function() {
									$("#username").val("<?php echo $username; ?>");
									$("#registerModal").modal("toggle");
									$("#loginModal").modal("show");
									$("#password").focus();
								}, 2000);
							</script>
						<?php
						} else {
						?>
							<div class="alert alert-danger text-center">
								<span>Ha habido un error. Contacte a un administrador.</span>
							</div>
<?php
						}
					}
				} else {
					header('location: /');
				}
			}
		}

		if ($action == 'newtopic') { //Acción para crear un nuevo tema junto a su categoría (si se asignó)
			if (isset($_POST['title']) || isset($_POST['content'])) {

				if ($user->isAdmin($id_user)) { //Acción para que se publique inmediatemente si es un administrador.
					$status = "approved";
					$reviewed_by = $id_user;
				} else {
					$status = "pending";
					$reviewed_by = "pending";
				}

				//Establecemos y relacionamos los datos obtenidos de AJAX hacia la consulta de inserción que se hará.
				$topicData = array(
					'id'			=> $topic->nextID(),
					'id_user' 		=> $id_user,
					'title' 		=> $title,
					'content' 		=> $content,
					'comments' 		=> 0,
					'views' 		=> 0,
					'status'		=> $status,
					'reviewed_by' 	=> $reviewed_by
				);

				$categoryData = array(
					'id_topic'		=> $topic->nextID(),
					'id_category' 	=> $topic->nextCategoryID($category),
					'name'			=> $category
				);

				//Vaciar los datos de categoría en caso de que el nombre no sea correcto. El criterio es muy básico y sería a elección del usuario.
				if (strlen($categoryData['name']) < 4) {
					$categoryData = null;
				}

				try {
					if (strlen($topicData['content']) < 50) { //Revisamos (nuevamente, porque ya lo hicimos en jQuery) que el contenido tenga más de 50 carácteres. Esto es una forma bastante simple de validar este input.
						echo  '<div class="alert alert-danger text-center">' . PHP_EOL;
						echo  '<span>El contenido debe tener mínimo 20 carácteres.</span>' . PHP_EOL;
						echo  '</div>' . PHP_EOL;
					} else {
						$topic->insertData('topic',	$topicData,	$categoryData);
						echo  '<div class="alert alert-success text-center">' . PHP_EOL;
						echo  '<span>La publicación se creó con éxito.</span>' . PHP_EOL;
						echo  '</div>' . PHP_EOL;
					}
				} catch (Exception $e) {
					echo  '<div class="alert alert-danger text-center">' . PHP_EOL;
					echo  '<span>' . $e->getTraceAsString() . '</span>' . PHP_EOL;
					echo  '</div>' . PHP_EOL;
				}
			} else {
				echo  '<div class="alert alert-danger text-center">' . PHP_EOL;
				echo  '<span>Debes completar todos los campos.</span>' . PHP_EOL;
				echo  '</div>' . PHP_EOL;
			}
		}
		if ($action == 'comment') { //Acción para crear comentarios.

			if ($user->isAdmin($id_user)) { //Acción para que se publique inmediatemente si es un administrador.
				$status = "approved";
				$reviewed_by = $id_user;
			} else {
				$status = "pending";
				$reviewed_by = "pending";
			}

			try {
				$topic->insertData(
					'comment',
					array(
						'id_topic'  	=> $id_object,
						'id_user' 		=> $id_user,
						'content' 		=> $content,
						'status'		=> $status
					)
				);
				echo  '<div class="alert alert-success text-center">' . PHP_EOL;
				echo  '<span>El comentario se publicó con éxito.</span>' . PHP_EOL;
				echo  '</div>' . PHP_EOL;
			} catch (Exception $e) {
				echo  '<div class="alert alert-danger text-center">' . PHP_EOL;
				echo  '<span>' . $e->getTraceAsString() . '</span>' . PHP_EOL;
				echo  '</div>' . PHP_EOL;
			}
		}
		if ($user->isAdmin()) { //Acciones que solo pueden hacer los administradores

			if ($action == 'approved') {

				try {
					if ($type == 'topics') {
						$topic->update($type, array(
							'status' 		=> $action,
							'reason' 		=> $reason,
							'reviewed_by' 	=> $id_user
						), 'id  = ' . $id_object);
					}

					if ($type == 'comments') {
						$topic->update($type, array(
							'status' 		=> $action,
							'reviewed_by' 	=> $id_user
						), 'id  = ' . $id_object);
					}

					if ($id_object == 'undefined' || empty($id_object)) {
						echo  '<div class="alert alert-danger text-center">' . PHP_EOL;
						echo  '<span>No se especificó el ID.</span>' . PHP_EOL;
						echo  '</div>' . PHP_EOL;
					}
					echo  '<div class="alert alert-success text-center">' . PHP_EOL;
					echo  '<span>El objeto se aprobó con éxito.</span>' . PHP_EOL;
					echo  '</div>' . PHP_EOL;
				} catch (Exception $e) {
					echo  '<div class="alert alert-danger text-center">' . PHP_EOL;
					echo  '<span>' . $e->getTraceAsString() . '</span>' . PHP_EOL;
					echo  '</div>' . PHP_EOL;
				}
			}

			if ($action == 'remove') {
				try {
					if ($type == 'topics') {
						$topic->delete('topics', 'id  = ' . $id_object);
						$topic->delete('categories', 'id_topic  = ' . $id_object);
						$topic->delete('comments', 'id_topic  = ' . $id_object);
					}
					if ($type == 'comments') {
						$topic->delete('comments', 'id  = ' . $id_object);
					}

					if ($id_object == 'undefined' || empty($id_object)) {
						echo  '<div class="alert alert-danger text-center">' . PHP_EOL;
						echo  '<span>No se especificó el ID.</span>' . PHP_EOL;
						echo  '</div>' . PHP_EOL;
					}
					echo  '<div class="alert alert-success text-center">' . PHP_EOL;
					echo  '<span>El objeto se eliminó con éxito.</span>' . PHP_EOL;
					echo  '</div>' . PHP_EOL;
				} catch (Exception $e) {
					echo  '<div class="alert alert-danger text-center">' . PHP_EOL;
					echo  '<span>' . $e->getTraceAsString() . '</span>' . PHP_EOL;
					echo  '</div>' . PHP_EOL;
				}
			}

			if ($action == 'refused') {
				try {
					$topic->update('topics', array(
						'status' 		=> $action,
						'reason' 		=> $reason,
						'reviewed_by' 	=> $id_user
					), 'id  = ' . $id_object);
					if ($id_object == 'undefined' || empty($id_object)) {
						echo  '<div class="alert alert-danger text-center">' . PHP_EOL;
						echo  '<span>No se especificó el ID.</span>' . PHP_EOL;
						echo  '</div>' . PHP_EOL;
					}
					echo  '<div class="alert alert-success text-center">' . PHP_EOL;
					echo  '<span>La publicación se rechazó correctamente.</span>' . PHP_EOL;
					echo  '</div>' . PHP_EOL;
				} catch (Exception $e) {
					echo  '<div class="alert alert-danger text-center">' . PHP_EOL;
					echo  '<span>' . $e->getTraceAsString() . '</span>' . PHP_EOL;
					echo  '</div>' . PHP_EOL;
				}
			}
		}
	}
}
