<?php
session_start();

if (!isset($_SESSION['tipoUsuario']) || $_SESSION['tipoUsuario'] != 'adm') {
    echo '<script>
                alert("Acesso negado.");
                window.location.href = "enterData.php";
        </script>';
    exit();
}

include('conn.php');

$sql = "SELECT dsPedido, hrPedido, mesaPedido, idPedido FROM pedido WHERE statusPedido = 1";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <style>
        .voltar-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            z-index: 1;
            padding: 25px;
            margin: 30px;
            font-size: 20px;
        }

        .container {
            margin-top: 80px; 
        }
    </style>
    <?php include('head.php'); ?>
    <title>Painel de Pedidos</title>
</head>
<body>
    <div class="container mt-12">
        <button type="button" class="btn btn-primary voltar-btn" onclick="voltarPagina()">
            <i class="fa-solid fa-left-long"></i>
        </button>

        <h2>Painel de Pedidos</h2>
        <table>
            <thead>
                <tr>
                    <th>ID do Pedido</th>
                    <th>Descrição do Pedido</th>
                    <th>Horário do Pedido</th>
                    <th>Mesa</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>
                                <td>' . intval($row['idPedido']) . '</td>
                                <td>' . htmlspecialchars($row['dsPedido']) . '</td>
                                <td>' . htmlspecialchars($row['hrPedido']) . '</td>
                                <td>' . htmlspecialchars($row['mesaPedido']) . '</td>
                                <td>
                                    <button type="button" class="btn-concluir" onclick="abrirModalConfirmacao(' . intval($row['idPedido']) . ')">Concluir Pedido</button>
                                </td>
                              </tr>';
                    }
                } else {
                    echo '<tr><td colspan="5" style="text-align:center;">Nenhum pedido encontrado.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php include('scriptImports.php'); ?>

    <div id="modalConfirmacao" class="modal-confirmacao" style="display:none;">
        <div class="modal-confirmacao-content">
            <div class="modal-confirmacao-header">
                <h5>Confirmação</h5>
                <span class="modal-confirmacao-close" onclick="fecharModalConfirmacao()">&times;</span>
            </div>
            <div class="modal-confirmacao-body">
                <p>O pedido foi realmente concluído?</p>
            </div>
            <div class="modal-confirmacao-footer">
                <form id="formConcluirPedido" action="concluirPedido.php" method="POST" style="display:inline;">
                    <input type="hidden" id="idPedidoConcluir" name="idPedido" value="">
                    <button type="submit" class="btn-concluir">Sim</button>
                </form>
                <button class="btn-nao" onclick="fecharModalConfirmacao()">Não</button>
            </div>
        </div>
    </div> <!-- modal confirmação -->

    <script>
        function voltarPagina(){
            window.location.href = "selecao-pagina.php";
        }

        function abrirModalConfirmacao(idPedido) {
            document.getElementById('idPedidoConcluir').value = idPedido;
            document.getElementById('modalConfirmacao').style.display = "flex"; 
        }

        function fecharModalConfirmacao() {
            document.getElementById('modalConfirmacao').style.display = "none"; 
        }

        function atualizarTabela() {
            fetch('getPedidos.php')
                .then(response => response.json())
                .then(data => {
                    const tbody = document.querySelector('tbody');
                    tbody.innerHTML = ''; 

                    data.forEach(pedido => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${pedido.idPedido}</td>
                            <td>${pedido.dsPedido}</td>
                            <td>${pedido.hrPedido}</td>
                            <td>${pedido.mesaPedido}</td>
                            <td>
                                <button type="button" class="btn-concluir" onclick="abrirModalConfirmacao(${pedido.idPedido})">Concluir Pedido</button>
                            </td>
                        `;
                        tbody.appendChild(tr);
                    });
                })
                .catch(error => console.error('Erro ao atualizar pedidos:', error));
        }

        setInterval(atualizarTabela, 5000);
        window.onload = atualizarTabela;
    </script>
</body>
</html>
