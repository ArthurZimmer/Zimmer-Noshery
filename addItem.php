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
</head>
<body>
        <!-- Modal -->
        <div id="modalAdicionar" class="modalAdicionar">
            <div class="modalAdicionar-content">
                <div class="modalAdicionar-header">
                    <h1 style="color: white; margin: 40px;">Adicionar Item</h1>
                </div>
                <div class="modalAdicionar-body">
                    <form id="formAdicionarItem" action="salvar-comida.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="nomeItem" style="color: white;">Nome do Item</label>
                            <input type="text" id="nomeItem" name="nmItem" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="descricaoItem" style="color: white;">Descrição</label>
                            <textarea id="descricaoItem" name="dsItem" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="precoItem" style="color: white;">Preço</label>
                            <input type="text" id="precoItem" name="precoItem" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="tempoPreparo" style="color: white;">Tempo de Preparo</label>
                            <input type="text" id="tempoPreparo" name="tempoItem" class="form-control">
                        </div>
                        <div class="mb-3">
                            <input type="file" name="file">
                        </div>
                    </form>
                </div>
                <div class="modalAdicionar-footer" style="margin-top: 20px;">
                    <button class="btn btn-secondary" onclick="voltarPag()">Cancelar</button>
                    <button type="submit" class="btn" form="formAdicionarItem">Salvar</button>
                </div>
            </div>
        </div> <!-- Modal -->

    <script>
       function voltarPag(){
            window.location.href = "comidasADM.php";
       }
    </script>

    </div> <!-- container -->
    <?php include('scriptImports.php'); ?>
</body>
</html>
