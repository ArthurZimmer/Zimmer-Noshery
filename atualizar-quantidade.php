<?php
include('conn.php');

if (isset($_POST['idPedido']) && isset($_POST['novaQuantidade'])) {
    $idPedido = $_POST['idPedido'];
    $novaQuantidade = $_POST['novaQuantidade'];
    
    try {
        // Inicia a transação
        $conn->begin_transaction();
        
        // Primeiro, pegamos as informações do item
        $sqlItem = "SELECT dsPedido, vlrPedido, idCliente FROM pedido WHERE idPedido = ?";
        $stmtItem = $conn->prepare($sqlItem);
        $stmtItem->bind_param("i", $idPedido);
        $stmtItem->execute();
        $resultItem = $stmtItem->get_result();
        $item = $resultItem->fetch_assoc();
        
        if (!$item) {
            throw new Exception("Item não encontrado");
        }
        
        // Removemos todos os registros existentes deste item
        $sqlDelete = "DELETE FROM pedido WHERE dsPedido = ? AND idCliente = ?";
        $stmtDelete = $conn->prepare($sqlDelete);
        $stmtDelete->bind_param("si", $item['dsPedido'], $item['idCliente']);
        $stmtDelete->execute();
        
        // Inserimos a nova quantidade de registros
        $sqlInsert = "INSERT INTO pedido (dsPedido, vlrPedido, idCliente) VALUES (?, ?, ?)";
        $stmtInsert = $conn->prepare($sqlInsert);
        
        for ($i = 0; $i < $novaQuantidade; $i++) {
            $stmtInsert->bind_param("sdi", $item['dsPedido'], $item['vlrPedido'], $item['idCliente']);
            $stmtInsert->execute();
        }
        
        // Commit da transação
        $conn->commit();
        
        // Calculamos o novo total
        $sqlTotal = "SELECT SUM(vlrPedido) as total FROM pedido WHERE idCliente = ?";
        $stmtTotal = $conn->prepare($sqlTotal);
        $stmtTotal->bind_param("i", $item['idCliente']);
        $stmtTotal->execute();
        $resultTotal = $stmtTotal->get_result();
        $totalRow = $resultTotal->fetch_assoc();
        $total = $totalRow['total'] ?? 0;
        
        // Retornamos o sucesso com os valores atualizados
        echo json_encode([
            'status' => 'success',
            'total' => number_format($total, 2, ',', '.'),
            'itemTotal' => number_format($item['vlrPedido'] * $novaQuantidade, 2, ',', '.')
        ]);
        
    } catch (Exception $e) {
        // Em caso de erro, faz rollback
        $conn->rollback();
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
    
    // Fecha as statements
    if (isset($stmtItem)) $stmtItem->close();
    if (isset($stmtDelete)) $stmtDelete->close();
    if (isset($stmtInsert)) $stmtInsert->close();
    if (isset($stmtTotal)) $stmtTotal->close();
}

$conn->close();
?>