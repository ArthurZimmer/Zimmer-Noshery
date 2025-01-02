<?php 
include('conn.php');

if (empty($_POST['nmItem']) || empty($_POST['dsItem']) || empty($_POST['precoItem']) || empty($_POST['tempoItem']) || empty($_FILES['file']['name'])) {
    echo '<script>
            alert("Por favor, preencha todos os campos.");
            window.history.back();
          </script>';
    exit();
}

$nomeItem = $_POST['nmItem'];
$descItem = $_POST['dsItem'];
$precoItem = $_POST['precoItem'];

// Formatação do tempo
$tempoItem = $_POST['tempoItem'];
$unidadeTempo = $_POST['unidadeTempo'];

// Converte o tempo para o formato correto (HH:MM:SS)
if ($unidadeTempo === 'minutos') {
    $minutos = intval($tempoItem);
    $horas = floor($minutos / 60);
    $minutosRestantes = $minutos % 60;
    $tempoFormatado = sprintf("%02d:%02d:00", $horas, $minutosRestantes);
} else { // se for horas
    $horas = intval($tempoItem);
    $tempoFormatado = sprintf("%02d:00:00", $horas);
}

// Processamento do arquivo
$file = $_FILES['file'];
$name = $file['name'];
$tmp_name = $file['tmp_name'];

$extension = pathinfo($name, PATHINFO_EXTENSION);
$newName = uniqid().'.'.$extension;

move_uploaded_file($tmp_name, 'img/fotos/'.$newName);

$fotoCaminho = 'img/fotos/' . $newName;
$precoItem = str_replace(',', '.', $precoItem);

$sql = "INSERT INTO itens (nmItem, dsitem, precoItem, tempoPreparo, dsFotos)
        VALUES ('$nomeItem', '$descItem', '$precoItem', '$tempoFormatado', '$fotoCaminho')";

if ($conn->query($sql) === TRUE) {
    header('Location: comidasADM.php');
} else {
    echo "Erro ao inserir dados: " . $conn->error;
}
?>