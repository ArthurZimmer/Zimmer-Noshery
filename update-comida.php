<?php
include('conn.php');

$idItem = $_POST['idItem'];
$nmItem = $_POST['nmItem'];
$tempoItem = $_POST['tempoItem'];
$precoItem = str_replace(',', '.', $_POST['precoItem']);
$dsItem = $_POST['dsItem'];

$sql = "UPDATE itens 
        SET nmItem='$nmItem', dsitem='$dsItem', precoItem='$precoItem', tempoPreparo='$tempoItem'  
        WHERE idItem=$idItem";

if ($conn->query($sql)) {
    header('Location: comidasADM.php');
} else {
    echo "Erro ao atualizar item: " . $conn->error;
}
?>
