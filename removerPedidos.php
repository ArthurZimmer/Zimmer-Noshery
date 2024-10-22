<?php
include('conn.php');

if (isset($_POST['idCliente'])) {
    $idCliente = $_POST['idCliente'];

    $sql = "DELETE FROM pedido WHERE idCliente = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idCliente);

    if ($stmt->execute()) {
        header("Location: comidas.php");
        exit();
    } else {
        echo "Erro ao remover os pedidos.";
    }
} else {
    echo "ID do cliente não encontrado.";
}
?>
