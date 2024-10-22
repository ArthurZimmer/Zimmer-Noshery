<?php 
	include('conn.php');

	$sql = "SELECT idItem, nmItem, dsItem, precoItem, tempoPreparo, dsFotos FROM itens";
	$result = $conn->query($sql);

?>