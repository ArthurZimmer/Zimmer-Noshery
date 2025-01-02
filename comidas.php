<?php include('captarComidas.php'); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="cssComidas.css">
    <title>Zimmer Noshery</title>
</head>
<body>
        <div class="container mt-12">
        <div class="header">
            <h1 class="page-title">Cardápio</h1>
        </div>
        <?php

            $sql2 = "SELECT idCliente FROM cliente ORDER BY idCliente DESC LIMIT 1";
            $result2 = $conn->query($sql2);
            
            $idCliente = ""; 

            if ($result2->num_rows > 0) {
                while ($row = $result2->fetch_assoc()) {
                    $idCliente = $row['idCliente'];
                }
            }

            // select para o número da mesa
            $sql3 = "SELECT nrMesa FROM cliente WHERE idCliente = $idCliente";
            $result3 = $conn->query($sql3);
            
            $mesaCliente = ""; 

            if ($result3->num_rows > 0) {
                while ($row = $result3->fetch_assoc()) {
                    $mesaCliente = $row['nrMesa'];
                }
            }

            // para verificar se o cliente já adicionou item ao pedido
            // aparecer o botão de finalizar
            $sqlPedido = "SELECT COUNT(*) AS totalItens FROM pedido WHERE idCliente = $idCliente";
            $resultPedido = $conn->query($sqlPedido);
            $totalItens = 0;

            if ($resultPedido->num_rows > 0) {
                $row = $resultPedido->fetch_assoc();
                $totalItens = $row['totalItens'];
            } 
        ?>

        <div class="cards-grid">
            <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo '
                        <div class="row">
                            <form method="POST" action="adicionar-item.php">
                                <div class="card">
                                    <img src="'. htmlspecialchars($row["dsFotos"]) .'" alt="" class="card-img">
                                    <div class="card-body">
                                        <p class="card-title"><strong>' . htmlspecialchars($row["nmItem"]) . '</strong></p>
                                        <p class="card-text">' . htmlspecialchars($row["dsItem"]) . '</p>
                                        <h5 class="card-text"><strong>R$ ' . number_format($row["precoItem"], 2, ',', '.') . '</strong></h5>
                                        <input type="hidden" name="item_nome" value="' . htmlspecialchars($row["nmItem"]) . '">
                                        <input type="hidden" name="item_preco" value="' . htmlspecialchars($row["precoItem"]) . '">
                                        <input type="hidden" name="item_tempo" value="' . htmlspecialchars($row["tempoPreparo"]) . '">
                                        <input type="hidden" name="idCliente" value="' . htmlspecialchars($idCliente) . '">
                                        <input type="hidden" name="numeroMesa" value="' . htmlspecialchars($mesaCliente) . '">
                                        <input type="submit" value="Adicionar ao pedido">
                                    </div>
                                </div>
                            </form>
                        </div>';
                    }
                } else {
                    echo '<p>Nenhum produto encontrado.</p>';
                }
            ?>
        </div>

        <?php
            if ($totalItens > 0) {
                echo '<div class="text-center mt-4">
                            <button class="btn-finalizar" onclick="abrirModal()">Editar ou finalizar Pedido</button>
                        </div>';
            }
        ?>

        <div id="modalConfirmacao" class="modal">
            <div class="modal-content">
                <h3>Itens do Pedido:</h3>
                <ul class="itens-pedido">
                    <?php
                    // Consulta modificada para contar itens iguais
                    $sqlItensPedido = "SELECT 
                        dsPedido, 
                        vlrPedido, 
                        COUNT(*) as quantidade, 
                        MIN(idPedido) as idPedido 
                        FROM pedido 
                        WHERE idCliente = $idCliente 
                        GROUP BY dsPedido, vlrPedido";
                    $resultItensPedido = $conn->query($sqlItensPedido);

                    if ($resultItensPedido->num_rows > 0) {
                        while ($row = $resultItensPedido->fetch_assoc()) {
                            $nomeItem = htmlspecialchars($row["dsPedido"]);
                            $precoUnitario = $row["vlrPedido"];
                            $quantidade = $row["quantidade"];
                            $precoTotal = number_format($precoUnitario * $quantidade, 2, ',', '.');
                            $idPedido = htmlspecialchars($row["idPedido"]);
                            
                            echo '
                                <li class="item-container" id="item-'.$idPedido.'" data-preco="'.$precoUnitario.'">
                                    <div class="item-info">
                                        <div class="item-principal">
                                            <span class="item-nome">' . $nomeItem . '</span>
                                            <span class="item-preco">R$ ' . $precoTotal . '</span>
                                        </div>
                                        <div class="item-controles">
                                            <div class="quantidade-wrapper">
                                                <button type="button" class="btn-quantidade" onclick="alterarQuantidade('.$idPedido.', -1)">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <span class="quantidade" id="qtd-'.$idPedido.'">' . $quantidade . '</span>
                                                <button type="button" class="btn-quantidade" onclick="alterarQuantidade('.$idPedido.', 1)">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                            <button class="btn-remover" onclick="removerItem('.$idPedido.')">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </button>
                                        </div>
                                    </div>
                                </li>';
                        }
                    }
                    ?>
                </ul><!-- itens-pedido -->

                <?php 
                    $sqlTotalPedido = "SELECT SUM(vlrPedido) AS totalPedido FROM pedido WHERE idCliente = $idCliente";
                    $resultTotalPedido = $conn->query($sqlTotalPedido);

                    if ($resultTotalPedido->num_rows > 0) {
                        $row = $resultTotalPedido->fetch_assoc();
                        $totalPedido = $row['totalPedido'];
                    } else {
                        $totalPedido = 0;
                    }

                    $totalPedidoFormatado = number_format($totalPedido, 2, ',', '.');
                ?>
      
                <!-- No modal, antes dos botões, adicione: -->
                <?php
                    $sqlVerificarPedido = "SELECT COUNT(*) as total FROM pedido WHERE idCliente = $idCliente";
                    $resultVerificar = $conn->query($sqlVerificarPedido);
                    $rowVerificar = $resultVerificar->fetch_assoc();
                    $temItens = $rowVerificar['total'] > 0;
                ?>

                <h5 id="totalPedido">Valor total: R$<?php echo $totalPedidoFormatado; ?></h5>

                <?php if ($temItens) { ?>
                    <h4>Podemos preparar seu pedido?</h4>
                    <div class="modal-buttons">
                        <button onclick="confirmarPedido()">Sim, por favor!</button>
                        <button onclick="fecharModal()">Não, preciso adicionar algo!</button>
                    </div>
                <?php } else { ?>
                    <div class="empty-cart">
                        <i class="fas fa-shopping-cart"></i>
                        <h3>Seu pedido está vazio</h3>
                        <p>Adicione alguns pratos deliciosos do nosso cardápio!</p>
                        <button onclick="fecharModal()" class="btn-voltar">
                            <i class="fas fa-arrow-left"></i>
                            Voltar ao Cardápio
                        </button>
                    </div>
                <?php } ?>

            </div> <!-- modal-content -->
        </div> <!-- Modal -->

    <script>
            function removerItem(idPedido) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "remover-item.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            var response = JSON.parse(xhr.responseText);
                            if (response.status === "success") {
                                var itemElement = document.getElementById("item-" + idPedido);
                                if (itemElement) {
                                    itemElement.remove();
                                }
                                
                                atualizarValorTotal();
                                verificarCarrinhoVazio();
                            } else {
                                alert("Erro ao remover item: " + response.message);
                            }
                        } else {
                            alert("Erro na requisição: " + xhr.status);
                        }
                    }
                };
                
                xhr.send("remove_item_id=" + idPedido);
            }

            function verificarCarrinhoVazio() {
                var itens = document.querySelectorAll('.item-container');
                if (itens.length === 0) {
                    // Se não houver mais itens, atualiza o conteúdo do modal
                    document.querySelector('.modal-content').innerHTML = `
                        <div class="empty-cart">
                            <i class="fas fa-shopping-cart"></i>
                            <h3>Seu carrinho está vazio</h3>
                            <p>Adicione alguns itens deliciosos do nosso cardápio!</p>
                            <button onclick="fecharModal()" class="btn-voltar">
                                <i class="fas fa-arrow-left"></i>
                                Voltar ao Cardápio
                            </button>
                        </div>
                    `;
                    
                    // Remove o botão de finalizar pedido da página principal
                    var btnFinalizar = document.querySelector('.btn-finalizar');
                    if (btnFinalizar) {
                        btnFinalizar.remove();
                    }
                }
            }

            function atualizarValorTotal() {
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "atualizar-total.php?idCliente=<?php echo $idCliente; ?>", true);
                
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        document.getElementById("totalPedido").innerHTML = "Valor total: R$ " + xhr.responseText;
                    }
                };
                
                xhr.send();
            }

            function alterarQuantidade(idPedido, delta) {
                const quantidadeElement = document.getElementById(`qtd-${idPedido}`);
                const itemContainer = document.getElementById(`item-${idPedido}`);
                let quantidade = parseInt(quantidadeElement.textContent);
                let novaQuantidade = quantidade + delta;
                
                if (novaQuantidade < 1) {
                    removerItem(idPedido);
                    return;
                }
                
                const precoUnitario = parseFloat(itemContainer.dataset.preco);
                
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "atualizar-quantidade.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        try {
                            const response = JSON.parse(xhr.responseText);
                            if (response.status === 'success') {
                                // Atualiza a quantidade
                                quantidadeElement.textContent = novaQuantidade;
                                
                                // Atualiza o preço do item
                                itemContainer.querySelector('.item-preco').textContent = `R$ ${response.itemTotal}`;
                                
                                // Atualiza o total geral
                                document.getElementById('totalPedido').textContent = `Valor total: R$ ${response.total}`;
                            } else {
                                alert("Erro ao atualizar quantidade: " + response.message);
                            }
                        } catch (e) {
                            console.error("Erro ao processar resposta:", e);
                            alert("Erro ao processar a resposta do servidor");
                        }
                    }
                };
                
                xhr.send(`idPedido=${idPedido}&novaQuantidade=${novaQuantidade}`);
            }

            function abrirModal() {
                document.getElementById("modalConfirmacao").style.display = "block";
                document.getElementById("modalConfirmacao").style.animation = "surgir 0.1s ease forwards"; 
            }

            function fecharModal() {
                const modal = document.getElementById("modalConfirmacao");
                modal.style.animation = "sair 0.1s ease forwards"; 
                setTimeout(() => {
                    modal.style.display = "none";
                }, 100);
            }

            function confirmarPedido() {
                var itens = document.querySelectorAll('.item-container');
                if (itens.length === 0) {
                    alert('Não é possível confirmar um pedido vazio!');
                    return;
                }
                fecharModal();
                window.location.href = "pedido-finalizado.php";
            }
        </script>

    </div> <!-- container -->
    <?php include('scriptImports.php'); ?>
</body>
</html>