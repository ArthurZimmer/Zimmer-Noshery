<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // pega o id do item q vai se removidp
    $idItem = isset($_POST['remove_item_id']) ? intval($_POST['remove_item_id']) : 0;

    if ($idItem > 0) {
        $sql = "DELETE FROM pedido WHERE idPedido = ?";
        $stmt = $conn->prepare($sql); 
        if ($stmt === false) {
            echo json_encode(["status" => "error", "message" => "Erro na preparação da consulta: " . $conn->error]);
            exit;
        }

        $stmt->bind_param("i", $idItem);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "ID inválido"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Método inválido"]);
}

$conn->close();
?>
