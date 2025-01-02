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
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');

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
            border-radius: 20px;
            border: 1px solid rgba(123, 0, 0, 0.3);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 500px;
            backdrop-filter: blur(10px);
            animation: fadeIn 0.5s ease-out;
        }

        .dashboard-title {
            color: #ff4d4d;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 30px;
            letter-spacing: 1px;
        }

        .button-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        button {
            background: linear-gradient(45deg, #8B0000, #ff4d4d);
            color: white;
            border: none;
            padding: 16px 30px;
            font-size: 16px;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(139, 0, 0, 0.3);
        }

        button:active {
            transform: translateY(0);
            box-shadow: 0 4px 8px rgba(139, 0, 0, 0.2);
        }

        .logout-btn {
            background: linear-gradient(45deg, #333, #666);
            margin-top: 20px;
        }

        /* Ícones para os botões */
        button i {
            font-size: 20px;
        }

        /* Animação de entrada */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Responsividade */
        @media (max-width: 600px) {
            .form-inicio {
                width: 90%;
                padding: 30px 20px;
            }

            button {
                padding: 14px 20px;
                font-size: 15px;
            }
        }
    </style>
    <!-- Adicione o link para os ícones do Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="form-inicio">
        <h1 class="dashboard-title">Painel de Controle</h1>
        <div class="button-container">
            <button onclick="window.location.href='comidasADM.php';">
                <i class="fas fa-utensils"></i>
                Editar Pratos
            </button>
            <button onclick="window.location.href='painel-pedidos.php';">
                <i class="fas fa-clipboard-list"></i>
                Painel de Pedidos
            </button>
            <button onclick="window.location.href='logout.php';" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                Sair
            </button>
        </div>
    </div>
</body>
</html>