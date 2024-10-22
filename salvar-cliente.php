<?php 
include("conn.php");

$nomeCliente = $_POST ['nome'];
$mesaCliente = $_POST ['numeroMesa'];
    
$sql = "INSERT INTO cliente (dsCliente, nrMesa) VALUES (?, ?)";
$stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'si', $nomeCliente, $mesaCliente);

        $result = mysqli_stmt_execute($stmt);

        if (!$result) {
            header("Location: erro404.html");
        } else {
            header("Location: comidas.php");
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Erro ao preparar a declaração:  " . mysqli_error($conn);
    }

    mysqli_close($conn);    
?>