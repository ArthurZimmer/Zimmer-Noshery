<?php include('captarComidas.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/estilo.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">   
     <title>Zimmer's Food</title>
</head>
<body>
    <div class="container mt-12">
        <a href="logout.php"><img class="center" src="img/cardápio-1.svg"  style="margin-left: 30%; margin-top: 50px;"></a>
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

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '
                <div class="row">
                    <form method="POST" action="adicionar-item.php">
                        <div class="col-12 mb-4">
                            <div class="card h-100">
                                <img src="'. htmlspecialchars($row["dsFotos"]) .'" alt="" class="card-img">
                                <div class="card-body">
                                    <p class="card-title"><strong>' . htmlspecialchars($row["nmItem"]) . '</strong></p>
                                    <p class="card-text">' . htmlspecialchars($row["dsItem"]) . '</p>
                                    <h5 class="card-text"><strong>R$ ' . number_format($row["precoItem"], 2, ',', '.') . '</strong></h5>
                                    <!-- Campos ocultos com os dados do item e cliente -->
                                    <input type="hidden" name="item_nome" value="' . htmlspecialchars($row["nmItem"]) . '">
                                    <input type="hidden" name="item_preco" value="' . htmlspecialchars($row["precoItem"]) . '">
                                    <input type="hidden" name="item_tempo" value="' . htmlspecialchars($row["tempoPreparo"]) . '">
                                    <input type="hidden" name="idCliente" value="' . htmlspecialchars($idCliente) . '">
                                    <input type="hidden" name="numeroMesa" value="' . htmlspecialchars($mesaCliente) . '">
                                    <input type="submit" value="Adicionar ao pedido">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>';
            }
        } else {
            echo '<p>Nenhum produto encontrado.</p>';
        }

        if ($totalItens > 0) {
            echo '<div class="text-center mt-4">
                        <button class="btn-finalizar" onclick="abrirModal()">Editar ou finalizar Pedido</button>
                    </div>';
        }
        ?>

        <div id="modalConfirmacao" class="modal">
            <div class="modal-content">
                <h3>Itens do Pedido:</h3>
                <ul class="itens-pedido" style="font-size: 20px; color: #f5f5f5; margin-bottom: 8px; padding: 40px;">
                    <?php
                    $sqlItensPedido = "SELECT idPedido, dsPedido, vlrPedido FROM pedido WHERE idCliente = $idCliente";
                    $resultItensPedido = $conn->query($sqlItensPedido);

                    if ($resultItensPedido->num_rows > 0) {
                        while ($row = $resultItensPedido->fetch_assoc()) {
                            $nomeItem = htmlspecialchars($row["dsPedido"]);
                            $precoItem = number_format($row["vlrPedido"], 2, ',', '.');
                            $idPedido = htmlspecialchars($row["idPedido"]);
                            echo '
                                <li class="item-container" id="item-'.$idPedido.'">
                                    <div class="item-info">' . $nomeItem . ' - R$ ' . $precoItem . '</div>
                                    <button class="btn-remover" onclick="removerItem('.$idPedido.')"><i class="fa-regular fa-trash-can"></i></button>
                                </li>';
                        }
                    } 
                    ?>
                </ul> <!-- itens-pedido -->

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
      
                <h5 id="totalPedido">Valor total: R$<?php echo $totalPedidoFormatado; ?></h5>
                <h4>Podemos preparar seu pedido?</h4>
                <div class="modal-buttons">
                    <button onclick="confirmarPedido()">Sim, por favor!</button>
                    <button onclick="fecharModal()">Não, preciso adicionar algo!</button>
                </div>
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
                fecharModal();
                window.location.href = "pedido-finalizado.php"; 
            }
        </script>

    </div> <!-- container -->
    <?php include('scriptImports.php'); ?>
</body>
</html>
