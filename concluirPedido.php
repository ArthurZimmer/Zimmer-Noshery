<?php 

	include('conn.php');

	$idPedido = $_POST['idPedido'];

	$sql = "UPDATE pedido 
        	SET statusPedido = 0 
        	WHERE idPedido = '$idPedido'";

	$result = $conn->query($sql);


	header('Location: painel-pedidos.php');

?>