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
<html>
<head>
    <?php include('head.php'); ?>
    <style>
        .voltar-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            z-index: 1;
            padding-left: 25px;
            padding-right: 25px;
            margin: 30px;
            font-size: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-12">
        <!-- Botão de voltar -->
        <button type="button" class="btn btn-primary voltar-btn" onclick="voltarPagina()">
            <i class="fa-solid fa-left-long"></i>
        </button>
        
        <img class="center" src="img/cardápio-1.svg"  style="margin-left: 30%; margin-top: 50px;">
        <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '
                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="card h-100">
                                <img src="'. htmlspecialchars($row["dsFotos"]) .'" alt="" class="card-img">
                                <div class="card-body">
                                    <p class="card-title"><strong>' . htmlspecialchars($row["nmItem"]) . '</strong></p>
                                    <p class="card-text">' . htmlspecialchars($row["dsItem"]) . '</p>
                                    <h5 class="card-text"><strong>R$ ' . number_format($row["precoItem"], 2, ',', '.') . '</strong></h5>
                                    <button type="button" class="btn btn-primary" onclick="abrirModalEditar(\'' . htmlspecialchars($row["nmItem"]) . '\', \'' . htmlspecialchars($row["precoItem"]) . '\', \'' . htmlspecialchars($row["tempoPreparo"]) . '\', \'' . htmlspecialchars($row["dsItem"]) . '\', ' . intval($row["idItem"]) . ')">
                                        Editar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>';
                }
            } else {
                echo '<p>Nenhum produto encontrado.</p>';
            }
        ?>
        <center><button type="button" class="btn btn-primary" onclick="paginaAddItem()" style="margin-bottom: 40px; font-size: 20px; padding: 30px; padding-top: 40px;"><i class="fa-solid fa-plus" style="margin-right: 15px; width: 30px; height: 30px;"></i>Adicionar prato</button></center>
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
                            <input type="text" id="nomeItem" name="nmItem" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="descricaoItem">Descrição</label>
                            <textarea id="descricaoItem" name="dsItem" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="precoItem">Preço</label>
                            <input type="text" id="precoItem" name="precoItem" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="tempoPreparo">Tempo de Preparo</label>
                            <input type="text" id="tempoPreparo" name="tempoItem" class="form-control">
                        </div>
                    </form>
                </div>
                <div class="modalEditar-footer">
                    <button class="btn btn-secondary" onclick="fecharModalEditar()">Cancelar</button>
                    
                    <!-- Form excluir-->
                    <form id="formExcluirPrato" action="excluirPrato.php" method="POST" style="display: inline;">
                        <input type="hidden" id="idItemExcluir" name="idItem" value="">
                        <button type="submit" class="btn btn-secondary">Excluir</button>
                    </form>
                    
                    <button type="submit" class="btn" form="formEditarItem">Salvar</button>
                </div>
            </div>
        </div> <!-- Modal -->

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
        </script>

    </div> <!-- container -->
    <?php include('scriptImports.php'); ?>
</body>
</html>
