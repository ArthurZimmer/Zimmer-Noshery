<?php include('conn.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <?php include('head.php'); ?>
</head>
<body>

<?php 
    $sql2 = "SELECT idCliente FROM cliente ORDER BY idCliente DESC LIMIT 1";
    $result2 = $conn->query($sql2);
    
    $idCliente = ""; 

    if ($result2->num_rows > 0) {
        while ($row = $result2->fetch_assoc()) {
            $idCliente = $row['idCliente'];
        }
    }

    $sql = "SELECT dsPedido, vlrPedido, mesaPedido, hrPedido FROM pedido WHERE idCliente = $idCliente";
    $result = $conn->query($sql);

    $dsPedidoList = "";
    $vlrTotal = 0;
    $mesaPedido = "";
    $hrPedido = "";

    if ($result->num_rows > 0) {           
        while ($row = $result->fetch_assoc()) {
            $dsPedidoList .= htmlspecialchars($row['dsPedido']) . ", ";
            $vlrTotal += $row['vlrPedido'];
            $mesaPedido = $row['mesaPedido'];
            $hrPedido = $row['hrPedido'];
        }
        $dsPedidoList = rtrim($dsPedidoList, ', ');
    }

    $vlrTotalFormatado = number_format($vlrTotal, 2, ',', '.');

    $horaPedido = new DateTime($hrPedido);
    $horaPedido->modify('+40 minutes');
    $horaEntregaEstimado = $horaPedido->format('H:i');

    echo '<div class="card-final">
            <h1>Tudo pronto, apenas aguardar seu pedido!</h1>
            <h3><strong>Pratos:</strong> ' . $dsPedidoList . '</h3>
            <h3><strong>Hora de Entrega Estimada:</strong> ' . $horaEntregaEstimado . '</h3>
            <h3><strong>Número da Mesa:</strong> ' . htmlspecialchars($mesaPedido) . '</h3>
            <h3><strong>Valor Total:</strong> R$ ' . $vlrTotalFormatado . '</h3>
            <a href="comidas.php" class="btn">Quero pedir mais alguma coisa!</a>
            <form action="removerPedidos.php" method="POST">
                <input type="hidden" name="idCliente" value="' . htmlspecialchars($idCliente) . '">
                <button type="submit" class="btn satisfeito-btn">Estou satisfeito!</button>
            </form>
          </div>';

?>

<?php include('scriptImports.php'); ?>
</body>
</html>
