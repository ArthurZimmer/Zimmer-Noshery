<?php
include('conn.php');

$sql = "SELECT dsPedido, hrPedido, mesaPedido, idPedido FROM pedido WHERE statusPedido = 1";
$result = $conn->query($sql);

$pedidos = array();
while ($row = $result->fetch_assoc()) {
    $pedidos[] = $row;
}

echo json_encode($pedidos);
?>
