<?php
session_start();

if (!isset($_SESSION['tipoUsuario']) || $_SESSION['tipoUsuario'] != 'adm') {
    echo '<script>
                alert("Acesso negado.");
                window.location.href = "enterData.php";
        </script>';
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?php include('head.php'); ?>
    <style>
    html, body {
        margin: 0;
        padding: 0;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #1C1C1C;
        font-family: 'Poppins', sans-serif;
    }

    .form-inicio {
        background-color: #141414;
        color: white;
        padding: 40px; 
        border-radius: 15px;
        border: 2px solid #7b0000;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
        width: 600px;     }

    button {
        display: block; 
        background-color: #8B0000;
        color: white;
        border: none;
        padding: 20px 40px; 
        font-size: 22px; 
        border-radius: 10px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
        margin: 20px auto; 
        width: 100%;
        max-width: 400px; 
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    button:hover {
        background-color: #a30000;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }

    button:active {
        background-color: #7a0000;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.15);
        transform: scale(0.98);
    }
</style>

</head>
<body>
    <div class="form-inicio">
        <center>
            <button onclick="window.location.href='comidasADM.php';">Editar pratos</button>
            <button onclick="window.location.href='painel-pedidos.php';">Painel de pedidos</button>
            <button onclick="window.location.href='logout.php';">Logout</button>
        </center>
    </div>
</body>
</html>
