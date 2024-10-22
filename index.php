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
            padding: 20px;
            border-radius: 15px;
            border: 2px solid #7b0000;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 500px;
        }

        h2 {
            margin-bottom: 20px;
            color: #ff4d4d;
        }

        input[type="text"], input[type="password"] {
            width: 80%;
            padding: 10px;
            font-size: 15px;
            border: 2px solid grey;
            border-radius: 8px;
            background-color: #141414;
            color: white;
            margin-top: 10px;
            margin-bottom: 20px;
            outline: none;
            transition: border 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        input[type="text"]:focus, input[type="password"]:focus {
            border-color: red;
            box-shadow: 0 6px 12px rgba(0, 123, 255, 0.3);
        }

        input[type="submit"] {
            background-color: #8B0000;
            color: white;
            border: none;
            padding: 15px 30px;
            font-size: 18px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        input[type="submit"]:hover {
            background-color: #a30000;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        input[type="submit"]:active {
            background-color: #7a0000;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.15);
            transform: scale(0.98);
        }


    </style>
</head>
<body>
    <div class="form-inicio">
        <h2>Login</h2>
        <form action="login.php" method="POST">
            <div class="input-group">
                <label for="username">Usuário </label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Senha </label>
                <input type="password" id="password" name="password" required>
            </div>
            <input type="submit" value="Entrar">
        </form>
    </div>
</body>
</html>
