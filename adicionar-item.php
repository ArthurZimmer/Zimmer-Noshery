<?php 

include('conn.php');
date_default_timezone_set('America/Sao_Paulo');

$idCliente = $_POST ['idCliente'];
$item_nome = $_POST['item_nome'];
$item_preco = $_POST['item_preco'];
$hora_pedido = date('H:i:s');
$mesaPedido = $_POST['numeroMesa'];


$sql = "INSERT INTO pedido (idCliente, dsPedido, hrPedido, vlrPedido, mesaPedido, statusPedido) 
        VALUES ('$idCliente', '$item_nome', '$hora_pedido', '$item_preco', '$mesaPedido', 1)";

$result = $conn->query($sql);

header('Location: comidas.php');

?>