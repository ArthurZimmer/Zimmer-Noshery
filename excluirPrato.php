<?php 

	include('conn.php');

	$idItem = $_POST['idItem'];

	$sql = "DELETE FROM itens WHERE idItem = $idItem";
	$result = $conn->query($sql);

	header('Location: comidasADM.php');
?>