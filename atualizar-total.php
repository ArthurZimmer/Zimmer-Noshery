<?php
include('conn.php'); 

$idCliente = $_GET['idCliente'];

$sqlTotalPedido = "SELECT SUM(vlrPedido) AS totalPedido FROM pedido WHERE idCliente = $idCliente";
$resultTotalPedido = $conn->query($sqlTotalPedido);

if ($resultTotalPedido->num_rows > 0) {
    $row = $resultTotalPedido->fetch_assoc();
    $totalPedido = $row['totalPedido'];
} else {
    $totalPedido = 0;
}

$totalPedidoFormatado = number_format($totalPedido, 2, ',', '.');

echo $totalPedidoFormatado;
?>
