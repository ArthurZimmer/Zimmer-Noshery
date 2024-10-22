<?php 
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	session_start();
	include('conn.php');

	$username = $_POST['username'];
	$senha = $_POST['password'];

	$query = "SELECT * FROM usuario WHERE dsUsuario = '$username' AND senhaUsuario = '$senha'";
	$resultado = mysqli_query($conn, $query);

	if (mysqli_num_rows($resultado) == 1) {
	    $usuario = mysqli_fetch_assoc($resultado);

	    $_SESSION['idUsuario'] = $usuario['idUsuario'];
	    $_SESSION['tipoUsuario'] = $usuario['tipoUsuario']; 

	    if ($_SESSION['tipoUsuario'] == 'adm') {
	        header('Location: selecao-pagina.php');
	    } else {
	        header('Location: enterData.php');
	    }
	} else {
	    echo '<script>
			    alert("Login incorreto. Por favor, verifique os campos e tente novamente.");
			    window.location.href = "index.php";
			</script>';
	}
?>
