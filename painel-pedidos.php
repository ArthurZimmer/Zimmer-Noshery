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
    <?php include('head.php'); ?>
    <title>Painel de Pedidos</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #1C1C1C;
            font-family: 'Poppins', sans-serif;
            color: white;
            margin: 0;
            padding: 0;
            height: 100vh;
            overflow: hidden; /* Impede scroll no body */
        }

        .container {
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
            height: 100vh;
            display: flex;
            flex-direction: column;
            position: relative; /* Para posicionamento do botão voltar */
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

        h2 {
            color: #ff4d4d;
            font-size: 32px;
            font-weight: 600;
            text-align: center;
            margin: 30px 0;
            letter-spacing: 1px;
        }

        .pedidos-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 15px;
            margin-top: 20px;
            flex: 1;
        }

        .pedidos-table tbody tr td[colspan="5"] {
            height: 200px; /* Altura mínima para mensagem de "nenhum pedido" */
            vertical-align: middle;
        }

        .pedidos-table thead {
            position: relative;
            margin-bottom: 20px;
        }

        .pedidos-table thead th {
            color: #ff4d4d;
            font-weight: 600;
            padding: 15px 20px;
            text-align: left;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            background: rgba(255, 77, 77, 0.05);
        }

        .pedidos-table thead th:first-child {
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
            padding-left: 25px;
        }

        .pedidos-table thead th:last-child {
            border-top-right-radius: 8px;
            border-bottom-right-radius: 8px;
            padding-right: 25px;
        }

        /* Ícones para cada coluna do cabeçalho */
        .pedidos-table thead th i {
            margin-right: 8px;
            font-size: 1rem;
            opacity: 0.9;
        }

        .pedidos-table tbody tr {
            background: linear-gradient(145deg, #1a1a1a, #141414);
            transition: all 0.3s ease;
            margin-bottom: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .pedidos-table tbody tr:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(255, 77, 77, 0.1);
        }

        .pedidos-table td {
            padding: 20px;
            color: #cccccc;
            font-size: 0.95rem;
        }

        .pedidos-table tr td:first-child {
            border-top-left-radius: 12px;
            border-bottom-left-radius: 12px;
            font-weight: 500;
            color: #ff4d4d;
            padding-left: 25px;
        }

        .pedidos-table tr td:last-child {
            border-top-right-radius: 12px;
            border-bottom-right-radius: 12px;
            padding-right: 25px;
        }

        /* Estilo para células vazias quando não há pedidos */
        .pedidos-table td[colspan="5"] {
            background: linear-gradient(145deg, #1a1a1a, #141414);
            border-radius: 12px;
            text-align: center;
        }

        /* Animação sutil para as linhas da tabela */
        .pedidos-table tbody tr {
            animation: fadeIn 0.3s ease-in-out;
        }

        

        .btn-concluir {
            background: linear-gradient(45deg, #8B0000, #ff4d4d);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .btn-concluir:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(139, 0, 0, 0.3);
        }

        /* Modal Styles */
        .modal-confirmacao {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.85);
            z-index: 1000;
            backdrop-filter: blur(5px);
            justify-content: center;
            align-items: center;
        }

        .modal-confirmacao-content {
            background: linear-gradient(145deg, #1a1a1a, #141414);
            border-radius: 20px;
            width: 90%;
            max-width: 400px;
            padding: 2rem;
            border: 1px solid rgba(255, 77, 77, 0.2);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
            animation: modalSlideIn 0.3s ease;
        }

        @keyframes modalSlideIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .modal-confirmacao-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .modal-confirmacao-header h5 {
            color: #ff4d4d;
            font-size: 1.5rem;
            margin: 0;
            font-weight: 600;
        }

        .modal-confirmacao-close {
            color: #cccccc;
            font-size: 1.8rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .modal-confirmacao-close:hover {
            color: #ff4d4d;
        }

        .modal-confirmacao-body {
            margin-bottom: 1.5rem;
            color: #cccccc;
            font-size: 1.1rem;
        }

        .modal-confirmacao-footer {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            padding-top: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .btn-nao {
            background: rgba(255, 255, 255, 0.1);
            color: #cccccc;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-nao:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .pedidos-table {
                display: block;
                overflow-x: auto;
            }

            .modal-confirmacao-content {
                width: 95%;
                margin: 20px;
            }
        }

        .table-container {
            flex: 1;
            overflow-y: auto; /* Adiciona scroll apenas na tabela */
            margin-top: 20px;
            padding-right: 10px; /* Espaço para scrollbar */
        }

        /* Estilização da scrollbar */
        .table-container::-webkit-scrollbar {
            width: 8px;
        }

        .table-container::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 4px;
        }

        .table-container::-webkit-scrollbar-thumb {
            background: rgba(255, 77, 77, 0.3);
            border-radius: 4px;
        }

        .table-container::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 77, 77, 0.5);
        }

        .pedidos-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 15px;
        }

        /* Ajuste do cabeçalho da tabela */
        .pedidos-table thead {
            position: sticky;
            top: 0;
            z-index: 1;
            background-color: #1C1C1C;
        }

    </style>
</head>
<body>
    <div class="container">
        <button type="button" class="voltar-btn" onclick="voltarPagina()">
            <i class="fa-solid fa-left-long"></i>
        </button>

        <h2>Painel de Pedidos</h2>
        <div class="table-container">
            <table class="pedidos-table">
                <thead>
                    <tr>
                        <th><i class="fas fa-hashtag"></i>ID do Pedido</th>
                        <th><i class="fas fa-utensils"></i>Descrição do Pedido</th>
                        <th><i class="fas fa-clock"></i>Horário do Pedido</th>
                        <th><i class="fas fa-chair"></i>Mesa</th>
                        <th><i class="fas fa-tasks"></i>Ações</th>
                    </tr>
                </thead>
                <tbody>
                     <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<tr>
                                        <td>#' . intval($row['idPedido']) . '</td>
                                        <td>' . htmlspecialchars($row['dsPedido']) . '</td>
                                        <td>' . htmlspecialchars($row['hrPedido']) . '</td>
                                        <td>Mesa ' . htmlspecialchars($row['mesaPedido']) . '</td>
                                        <td>
                                            <button type="button" class="btn-concluir" onclick="abrirModalConfirmacao(' . intval($row['idPedido']) . ')">
                                                <i class="fas fa-check"></i> Concluir
                                            </button>
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
    </div>

    <!-- Modal de Confirmação -->
    <div id="modalConfirmacao" class="modal-confirmacao">
        <div class="modal-confirmacao-content">
            <div class="modal-confirmacao-header">
                <h5>Confirmação</h5>
                <span class="modal-confirmacao-close" onclick="fecharModalConfirmacao()">&times;</span>
            </div>
            <div class="modal-confirmacao-body">
                <p>O pedido foi realmente concluído?</p>
            </div>
            <div class="modal-confirmacao-footer">
                <button class="btn-nao" onclick="fecharModalConfirmacao()">Não</button>
                <form id="formConcluirPedido" action="concluirPedido.php" method="POST" style="display:inline;">
                    <input type="hidden" id="idPedidoConcluir" name="idPedido" value="">
                    <button type="submit" class="btn-concluir">
                        <i class="fas fa-check"></i> Sim
                    </button>
                </form>
            </div>
        </div>
    </div>

    <?php include('scriptImports.php'); ?>

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

                    if (data && data.length > 0) {
                        data.forEach(pedido => {
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                                <td>#${pedido.idPedido}</td>
                                <td>${pedido.dsPedido}</td>
                                <td>${pedido.hrPedido}</td>
                                <td>Mesa ${pedido.mesaPedido}</td>
                                <td>
                                    <button type="button" class="btn-concluir" onclick="abrirModalConfirmacao(${pedido.idPedido})">
                                        <i class="fas fa-check"></i> Concluir
                                    </button>
                                </td>
                            `;
                            tbody.appendChild(tr);
                        });
                    } else {
                        tbody.innerHTML = `
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 30px; color: #cccccc; font-size: 1.1rem;">
                                    <i class="fas fa-clipboard-list" style="font-size: 2rem; margin-bottom: 15px; color: #ff4d4d;"></i>
                                    <br>
                                    Nenhum pedido encontrado.
                                </td>
                            </tr>`;
                    }
                })
                .catch(error => {
                    console.error('Erro ao atualizar pedidos:', error);
                    const tbody = document.querySelector('tbody');
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 30px; color: #cccccc;">
                                Erro ao carregar pedidos. Por favor, recarregue a página.
                            </td>
                        </tr>`;
                });
        }

        setInterval(atualizarTabela, 5000);
        window.onload = atualizarTabela;
    </script>
</body>
</html>