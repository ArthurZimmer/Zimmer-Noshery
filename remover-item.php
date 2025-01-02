<?php
include('conn.php');

if (isset($_POST['remove_item_id'])) {
    $idPedido = $_POST['remove_item_id'];
    
    // Primeiro, pegamos o nome do item para remover todos os registros iguais
    $sqlNomeItem = "SELECT dsPedido FROM pedido WHERE idPedido = ?";
    $stmtNome = $conn->prepare($sqlNomeItem);
    $stmtNome->bind_param("i", $idPedido);
    $stmtNome->execute();
    $resultNome = $stmtNome->get_result();
    $row = $resultNome->fetch_assoc();
    $nomeItem = $row['dsPedido'];
    
    // Agora removemos todos os itens com o mesmo nome
    $sqlDelete = "DELETE FROM pedido WHERE dsPedido = ? AND idCliente = (SELECT idCliente FROM pedido WHERE idPedido = ?)";
    $stmtDelete = $conn->prepare($sqlDelete);
    $stmtDelete->bind_param("si", $nomeItem, $idPedido);
    
    if ($stmtDelete->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $conn->error]);
    }
}
?>