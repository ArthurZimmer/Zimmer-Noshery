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
            width: 400px;
            backdrop-filter: blur(10px);
        }

        h2 {
            margin-bottom: 30px;
            color: #ff4d4d;
            font-size: 28px;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .input-group {
            margin-bottom: 25px;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            color: #999;
            font-weight: 500;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            font-size: 14px;
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            background-color: rgba(255, 255, 255, 0.05);
            color: white;
            outline: none;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        input[type="text"]:focus, input[type="password"]:focus {
            border-color: #ff4d4d;
            background-color: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 15px rgba(255, 77, 77, 0.1);
        }

        input[type="submit"] {
            background: linear-gradient(45deg, #8B0000, #ff4d4d);
            color: white;
            border: none;
            padding: 14px 32px;
            font-size: 16px;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            width: 100%;
            margin-top: 10px;
        }

        input[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(139, 0, 0, 0.3);
        }

        input[type="submit"]:active {
            transform: translateY(0);
            box-shadow: 0 4px 8px rgba(139, 0, 0, 0.2);
        }

        /* Adicione uma animação suave ao carregar */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-inicio {
            animation: fadeIn 0.5s ease-out;
        }

    </style>
</head>
<body>
    <div class="form-inicio">
        <h2>Login</h2>
        <form action="login.php" method="POST">
            <div class="input-group">
                <label for="username">Usuário</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Senha</label>
                <input type="password" id="password" name="password" required>
            </div>
            <input type="submit" value="Entrar">
        </form>
    </div>
</body>
</html>