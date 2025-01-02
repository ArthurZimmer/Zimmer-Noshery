<?php 
session_start();

if (!isset($_SESSION['tipoUsuario'])) {
    header('Location: acesso_negado.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <title>Zimmer Noshery</title>
	<!-- Adicione no head uma destas fontes -->
	<link href="https://fonts.googleapis.com/css2?family=Archivo+Black&display=swap" rel="stylesheet">
	<!-- ou -->
	<link href="https://fonts.googleapis.com/css2?family=Rubik:wght@900&display=swap" rel="stylesheet">
	<!-- ou -->
	<link href="https://fonts.googleapis.com/css2?family=Bungee&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #1C1C1C;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            background: linear-gradient(145deg, #1a1a1a, #141414);
            border-radius: 24px;
            padding: 2.5rem;
            width: 100%;
            max-width: 500px;
            border: 1px solid rgba(255, 77, 77, 0.1);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            animation: containerFadeIn 0.5s ease;
        }

        @keyframes containerFadeIn {
            from { 
                opacity: 0;
                transform: translateY(-20px);
            }
            to { 
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo {
            width: 100px;
            height: 100px;
            margin-bottom: 1.5rem;
            animation: logoSpin 20s linear infinite;
        }

        @keyframes logoSpin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .title {
            color: #ff4d4d;
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 1rem;
            letter-spacing: 1px;
        }

        .subtitle {
            color: #cccccc;
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            color: #ff4d4d;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            font-weight: 500;
        }

        input {
            width: 100%;
            padding: 12px 15px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 77, 77, 0.2);
            border-radius: 12px;
            color: white;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        input:focus {
            outline: none;
            border-color: #ff4d4d;
            box-shadow: 0 0 15px rgba(255, 77, 77, 0.1);
        }

        .mesa-selector {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-top: 0.5rem;
        }

        .mesa-btn {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 77, 77, 0.2);
            border-radius: 8px;
            color: white;
            padding: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .mesa-btn:hover {
            background: rgba(255, 77, 77, 0.1);
            transform: translateY(-2px);
        }

        .mesa-btn.selected {
            background: linear-gradient(45deg, #8B0000, #ff4d4d);
            border-color: transparent;
            box-shadow: 0 5px 15px rgba(255, 77, 77, 0.2);
        }

        .submit-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(45deg, #8B0000, #ff4d4d);
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 77, 77, 0.2);
        }

        @media (max-width: 480px) {
            .container {
                padding: 1.5rem;
            }

            .mesa-selector {
                grid-template-columns: repeat(3, 1fr);
            }

            .title {
                font-size: 1.5rem;
            }
        }

        .title span {
		    font-family: 'Bungee', cursive; /* ou 'Archivo Black' ou 'Rubik' */
		    font-size: 2.4rem;
		    font-weight: 900;
		    letter-spacing: 2px;
		    text-transform: uppercase;
		    color: #ff4d4d;
		    text-shadow: 
		        4px 4px 0 #1C1C1C,
		        5px 5px 0px rgba(0, 0, 0, 0.2);
		    -webkit-text-stroke: 1px #1C1C1C;
		    display: block;
		    margin-top: 10px;
		}
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="img/logo.png" alt="Logo" class="logo">
            <h1 class="title">Bem-vindo ao <span>Zimmer Noshery</span></h1>
            <p class="subtitle">Por favor, identifique-se para fazer seu pedido</p>
        </div>

        <form action="comidas.php" method="POST">
            <div class="form-group">
                <label for="nome">Seu Nome</label>
                <input type="text" id="nome" name="nome" required placeholder="Digite seu nome">
            </div>

            <div class="form-group">
			    <label for="mesa">Número da Mesa</label>
			    <input type="number" 
			           id="mesa" 
			           name="mesa" 
			           min="1" 
			           required 
			           placeholder="Digite o número da sua mesa"
			           class="mesa-input">
			</div>

            <button type="submit" class="submit-btn">
                <i class="fas fa-arrow-right"></i>
                Continuar para o Cardápio
            </button>
        </form>
    </div>

    <?php include('scriptImports.php'); ?>

    <script>
        function selecionarMesa(numero) {
            // Remove a seleção anterior
            document.querySelectorAll('.mesa-btn').forEach(btn => {
                btn.classList.remove('selected');
            });
            
            // Seleciona a nova mesa
            event.target.classList.add('selected');
            document.getElementById('mesa_selecionada').value = numero;
        }
    </script>
</body>
</html>