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

<?php include('captarComidas.php'); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?php include('head.php'); ?>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');

        body {
            background-color: #1C1C1C;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .modalAdicionar-content {
            background-color: #141414;
            border-radius: 20px;
            width: 90%;
            max-width: 600px;
            padding: 2rem;
            border: 1px solid rgba(123, 0, 0, 0.3);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            animation: modalFadeIn 0.3s ease;
        }

        @keyframes modalFadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .modalAdicionar-header h1 {
            color: #ff4d4d;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 30px;
            text-align: center;
            letter-spacing: 1px;
        }

        .mb-3 {
            margin-bottom: 20px;
        }

        label {
            display: block;
            color: #cccccc;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: white;
            font-size: 14px;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .form-control:focus {
            border-color: #ff4d4d;
            background-color: rgba(255, 255, 255, 0.08);
            outline: none;
            box-shadow: 0 0 15px rgba(255, 77, 77, 0.1);
        }

        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }

        /* Estilização do input file */
        .file-input-wrapper {
            width: 100%;
            box-sizing: border-box;
        }

        /* Estilização do input file */
        input[type="file"] {
            width: 100%;
            padding: 10px;
            background-color: rgba(255, 255, 255, 0.05);
            border: 2px dashed rgba(255, 77, 77, 0.3);
            border-radius: 12px;
            color: #cccccc;
            cursor: pointer;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        input[type="file"]:hover {
            border-color: #ff4d4d;
            background-color: rgba(255, 77, 77, 0.05);
        }

        .modalAdicionar-footer {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .btn {
            padding: 12px 25px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-secondary {
            background-color: #333;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #444;
            transform: translateY(-2px);
        }

        button[type="submit"] {
            background: linear-gradient(45deg, #8B0000, #ff4d4d);
            color: white;
        }

        button[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(139, 0, 0, 0.3);
        }

        /* Responsividade */
        @media (max-width: 768px) {
            .modalAdicionar-content {
                width: 95%;
                padding: 1.5rem;
                margin: 15px;
            }

            .modalAdicionar-header h1 {
                font-size: 24px;
            }

            .btn {
                padding: 10px 20px;
            }
        }

        .tempo-preparo-container {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 8px;
        }

        .tempo-btn {
            background: linear-gradient(45deg, #8B0000, #ff4d4d);
            color: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 18px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .tempo-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 77, 77, 0.2);
        }

        .tempo-preparo-container input {
            text-align: center;
            width: 100px;
            padding: 12px 15px;
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: white;
            font-size: 14px;
            -moz-appearance: textfield; /* Remove spinner no Firefox */
        }

        /* Remove spinner nos navegadores Webkit (Chrome, Safari, etc.) */
        .tempo-preparo-container input::-webkit-outer-spin-button,
        .tempo-preparo-container input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .tempo-preparo-container select {
            flex: 1;
            padding: 12px 15px;
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: white;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            appearance: none; /* Remove a aparência padrão do select */
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23ffffff' d='M6 8.825L1.175 4 2.238 2.938 6 6.7l3.763-3.762L10.825 4z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            padding-right: 40px; /* Espaço para o ícone */
        }

        .tempo-preparo-container select:hover,
        .tempo-preparo-container select:focus {
            border-color: #ff4d4d;
            background-color: rgba(255, 255, 255, 0.08);
            outline: none;
            box-shadow: 0 0 15px rgba(255, 77, 77, 0.1);
        }

        .tempo-preparo-container select option {
            background-color: #1C1C1C;
            color: white;
            padding: 10px;
        }

    </style>
</head>
<body>
    <div class="modalAdicionar">
        <div class="modalAdicionar-content">
            <div class="modalAdicionar-header">
                <h1>Adicionar Item ao Cardápio</h1>
            </div>
            <div class="modalAdicionar-body">
                <form id="formAdicionarItem" action="salvar-comida.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="nomeItem">Nome do Item</label>
                        <input type="text" id="nomeItem" name="nmItem" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="descricaoItem">Descrição</label>
                        <textarea id="descricaoItem" name="dsItem" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="precoItem">Preço</label>
                        <input type="text" id="precoItem" name="precoItem" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="tempoPreparo">Tempo de Preparo</label>
                        <div class="tempo-preparo-container">
                            <button type="button" class="tempo-btn" onclick="decrementTempo()">-</button>
                            <input type="number" 
                                   id="tempoPreparo" 
                                   name="tempoItem" 
                                   class="form-control" 
                                   min="1" 
                                   value="30" 
                                   required 
                                   readonly>
                            <button type="button" class="tempo-btn" onclick="incrementTempo()">+</button>
                            <select id="unidadeTempo" name="unidadeTempo" class="form-control">
                                <option value="minutos">Minutos</option>
                                <option value="horas">Horas</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="file">Imagem do Prato</label>
                        <div class="file-input-wrapper">
                            <input type="file" id="file" name="file" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modalAdicionar-footer">
                <button class="btn btn-secondary" onclick="voltarPag()">Cancelar</button>
                <button type="submit" class="btn" form="formAdicionarItem">Salvar</button>
            </div>
        </div>
    </div>

    <?php include('scriptImports.php'); ?>
    <script>
        function voltarPag(){
            window.location.href = "comidasADM.php";
        }
        function incrementTempo() {
            const input = document.getElementById('tempoPreparo');
            const unidade = document.getElementById('unidadeTempo').value;
            const incremento = unidade === 'minutos' ? 5 : 1;
            input.value = parseInt(input.value) + incremento;
        }

        function decrementTempo() {
            const input = document.getElementById('tempoPreparo');
            const unidade = document.getElementById('unidadeTempo').value;
            const incremento = unidade === 'minutos' ? 5 : 1;
            const newValue = parseInt(input.value) - incremento;
            if (newValue >= 1) {
                input.value = newValue;
            }
        }

        // Ajusta o incremento quando a unidade é alterada
        document.getElementById('unidadeTempo').onchange = function() {
            const input = document.getElementById('tempoPreparo');
            if (this.value === 'horas') {
                input.value = Math.ceil(parseInt(input.value) / 60);
            } else {
                input.value = parseInt(input.value) * 60;
            }
        };
    </script>
</body>
</html>