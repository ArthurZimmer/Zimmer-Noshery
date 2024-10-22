<?php 

session_start();

	if (!isset($_SESSION['tipoUsuario'])) {
	    header('Location: acesso_negado.php');
	    exit();
	}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/estilo.css" />
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">	
	 <title>Zimmer's Food</title>
</head>
<body>
	<?php include('home.php'); ?>
	<?php include('scriptImports.php'); ?>
</body>
</html>