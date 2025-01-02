<?php
session_start();

// verifica o tipo de usuário
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
            color: white;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .voltar-btn {
            position: fixed;
            top: 20px;
            left: 20px;
            background: linear-gradient(45deg, #8B0000, #ff4d4d);
            border: none;
            padding: 12px 25px;
            border-radius: 12px;
            color: white;
            font-size: 16px;
            transition: all 0.3s ease;
            z-index: 1000;
            cursor: pointer;
        }

        .voltar-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(139, 0, 0, 0.3);
        }

        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 2.5rem;
            padding: 2rem 0;
        }

        .card {
            background: linear-gradient(145deg, #1a1a1a, #141414);
            border: 1px solid rgba(255, 77, 77, 0.1);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s ease;
            height: 100%;
            position: relative;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(255, 77, 77, 0.15);
            border-color: rgba(255, 77, 77, 0.3);
        }

        .card-img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            transition: all 0.4s ease;
            border-bottom: 1px solid rgba(255, 77, 77, 0.1);
        }

        .card:hover .card-img {
            transform: scale(1.05);
        }

        .card-body {
            padding: 1.8rem;
            background: linear-gradient(180deg, rgba(26, 26, 26, 0.9) 0%, rgba(20, 20, 20, 1) 100%);
        }

        .card-title {
            color: #ff4d4d;
            font-size: 1.4rem;
            margin-bottom: 1rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            line-height: 1.4;
        }

        .card-text {
            color: #cccccc;
            margin-bottom: 1.2rem;
            font-size: 0.95rem;
            line-height: 1.6;
            opacity: 0.9;
        }

        .card-price {
            font-size: 1.3rem;
            color: #fff;
            font-weight: 600;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .card-price::before {
            content: 'R$';
            font-size: 1rem;
            color: #ff4d4d;
        }

        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1.5rem;
        }

        .card .btn {
            width: 100%;
            padding: 12px 24px;
            background: linear-gradient(45deg, #8B0000, #ff4d4d);
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .card .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 77, 77, 0.2);
        }

        .card .btn i {
            font-size: 1.1rem;
        }

        /* Adicione uma marca d'água decorativa */
        .card::before {
            content: '';
            position: absolute;
            top: 10px;
            right: 10px;
            width: 40px;
            height: 40px;
            background: linear-gradient(45deg, #ff4d4d, #8B0000);
            border-radius: 50%;
            opacity: 0.1;
            z-index: 1;
        }

        .btn {
            background: linear-gradient(45deg, #8B0000, #ff4d4d);
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(139, 0, 0, 0.3);
        }

        .add-btn {
            background: linear-gradient(45deg, #8B0000, #ff4d4d);
            border: none;
            padding: 15px 30px;
            border-radius: 12px;
            color: white;
            font-size: 18px;
            margin: 2rem 0;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .add-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(139, 0, 0, 0.3);
        }

        .modalEditar {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.85);
            z-index: 1000;
            backdrop-filter: blur(5px);
        }

        .modalEditar-content {
            background: linear-gradient(145deg, #1a1a1a, #141414);
            border-radius: 24px;
            width: 90%;
            max-width: 500px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 2.5rem;
            border: 1px solid rgba(255, 77, 77, 0.2);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
            animation: modalSlideIn 0.3s ease;
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translate(-50%, -60%);
            }
            to {
                opacity: 1;
                transform: translate(-50%, -50%);
            }
        }

        .modalEditar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .modalEditar-header h5 {
            color: #ff4d4d;
            font-size: 1.8rem;
            font-weight: 600;
            margin: 0;
            letter-spacing: 0.5px;
        }

        .modalEditar-close {
            color: #cccccc;
            font-size: 2rem;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
        }

        .modalEditar-close:hover {
            color: #ff4d4d;
            background: rgba(255, 77, 77, 0.1);
            transform: rotate(90deg);
        }

        .modalEditar-body {
            margin-bottom: 2rem;
        }

        .modalEditar label {
            color: #ff4d4d;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 0.8rem;
            display: block;
            letter-spacing: 0.5px;
        }

        .modalEditar .form-control {
            width: 100%;
            padding: 14px 18px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 77, 77, 0.2);
            border-radius: 14px;
            color: white;
            font-size: 1rem;
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
            box-sizing: border-box;
        }

        .modalEditar .form-control:focus {
            border-color: #ff4d4d;
            background: rgba(255, 255, 255, 0.05);
            outline: none;
            box-shadow: 0 0 20px rgba(255, 77, 77, 0.15);
        }

        .modalEditar textarea.form-control {
            min-height: 120px;
            resize: vertical;
            line-height: 1.6;
        }

        .modalEditar-footer {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .modalEditar-footer .btn {
            padding: 12px 24px;
            font-size: 0.9rem;
            font-weight: 500;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .modalEditar-footer .btn-cancel {
            background: rgba(255, 255, 255, 0.1);
            color: #cccccc;
        }

        .modalEditar-footer .btn-delete {
            background: linear-gradient(45deg, #dc3545, #ff4444);
        }

        .modalEditar-footer .btn-save {
            background: linear-gradient(45deg, #8B0000, #ff4d4d);
        }

        .modalEditar-footer .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <div class="container">
        <button type="button" class="voltar-btn" onclick="voltarPagina()">
            <i class="fa-solid fa-left-long"></i>
        </button>
        
        <h1 style="color: #ff4d4d; font-size: 32px; font-weight: 600; text-align: center; margin: 50px 0; letter-spacing: 1px;">Edição de Cardápio</h1>

        <div class="cards-grid">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '
                    <div class="card">
                        <img src="'. htmlspecialchars($row["dsFotos"]) .'" alt="" class="card-img">
                        <div class="card-body">
                            <h3 class="card-title">' . htmlspecialchars($row["nmItem"]) . '</h3>
                            <p class="card-text">' . htmlspecialchars($row["dsItem"]) . '</p>
                            <div class="card-price">' . number_format($row["precoItem"], 2, ',', '.') . '</div>
                            <button type="button" class="btn" onclick="abrirModalEditar(\'' . htmlspecialchars($row["nmItem"]) . '\', \'' . htmlspecialchars($row["precoItem"]) . '\', \'' . htmlspecialchars($row["tempoPreparo"]) . '\', \'' . htmlspecialchars($row["dsItem"]) . '\', ' . intval($row["idItem"]) . ')">
                                <i class="fas fa-edit"></i>
                                Editar
                            </button>
                        </div>
                    </div>';
                }
            } else {
                echo '<p>Nenhum produto encontrado.</p>';
            }
            ?>
        </div>

        <center>
            <button type="button" class="add-btn" onclick="paginaAddItem()">
                <i class="fa-solid fa-plus" style="margin-right: 15px;"></i>
                Adicionar prato
            </button>
        </center>

        <!-- Modal -->
        <!-- Modal -->
        <div id="modalEditar" class="modalEditar">
            <div class="modalEditar-content">
                <div class="modalEditar-header">
                    <h5>Editar Item</h5>
                    <span class="modalEditar-close" onclick="fecharModalEditar()">&times;</span>
                </div>
                <div class="modalEditar-body">
                    <form id="formEditarItem" action="update-comida.php" method="POST">
                        <input type="hidden" id="idItem" name="idItem" value="">
                        <div class="mb-3">
                            <label for="nomeItem">Nome do Item</label>
                            <input type="text" id="nomeItem" name="nmItem" class="form-control" placeholder="Digite o nome do item">
                        </div>
                        <div class="mb-3">
                            <label for="descricaoItem">Descrição</label>
                            <textarea id="descricaoItem" name="dsItem" class="form-control" placeholder="Descreva os ingredientes e detalhes do prato"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="precoItem">Preço</label>
                            <input type="text" id="precoItem" name="precoItem" class="form-control" placeholder="R$ 0,00">
                        </div>
                        <div class="mb-3">
                            <label for="tempoPreparo">Tempo de Preparo</label>
                            <input type="text" id="tempoPreparo" name="tempoItem" class="form-control" placeholder="Ex: 30 minutos">
                        </div>
                    </form>
                </div>
                <div class="modalEditar-footer">
                    <button class="btn btn-cancel" onclick="fecharModalEditar()">
                        <i class="fas fa-times"></i>
                        Cancelar
                    </button>
                    
                    <form id="formExcluirPrato" action="excluirPrato.php" method="POST" style="display: inline;">
                        <input type="hidden" id="idItemExcluir" name="idItem" value="">
                        <button type="submit" class="btn btn-delete">
                            <i class="fas fa-trash-alt"></i>
                            Excluir
                        </button>
                    </form>
                    
                    <button type="submit" class="btn btn-save" form="formEditarItem">
                        <i class="fas fa-save"></i>
                        Salvar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php include('scriptImports.php'); ?>

    <script>
        function voltarPagina(){
            window.location.href = "selecao-pagina.php";
        }

        function abrirModalEditar(nomeItem, precoItem, tempoPreparo, dsItem, idItem) {
            preencherModal(nomeItem, precoItem, tempoPreparo, dsItem, idItem);
            document.getElementById("modalEditar").style.display = "block";
            document.getElementById('idItemExcluir').value = idItem;
        }

        function preencherModal(nomeItem, precoItem, tempoPreparo, dsItem, idItem) {
            document.getElementById('nomeItem').value = nomeItem;
            document.getElementById('precoItem').value = precoItem;
            document.getElementById('tempoPreparo').value = tempoPreparo;
            document.getElementById('descricaoItem').value = dsItem;
            document.getElementById('idItem').value = idItem;
        }

        function fecharModalEditar() {
            document.getElementById("modalEditar").style.display = "none";
        }

        function paginaAddItem(){
            window.location.href = "addItem.php";
        }

        // Fechar modal quando clicar fora dele
        window.onclick = function(event) {
            if (event.target == document.getElementById("modalEditar")) {
                fecharModalEditar();
            }
        }
    </script>
</body>
</html>