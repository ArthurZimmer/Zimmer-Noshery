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
$tempoItem = $_POST['tempoItem'];

$file = $_FILES['file'];
$name = $file['name'];
$tmp_name = $file['tmp_name'];

$extension = pathinfo($name, PATHINFO_EXTENSION);
$newName = uniqid().'.'.$extension;

move_uploaded_file($tmp_name, 'img/fotos/'.$newName);

$fotoCaminho = 'img/fotos/' . $newName;
$precoItem = str_replace(',', '.', $precoItem);

$sql = "INSERT INTO itens (nmItem, dsitem, precoItem, tempoPreparo, dsFotos)
        VALUES ('$nomeItem', '$descItem', '$precoItem', '$tempoItem', '$fotoCaminho')";

if ($conn->query($sql) === TRUE) {
    header('Location: comidasADM.php');
} else {
    echo "Erro ao inserir dados: " . $conn->error;
}
?>
