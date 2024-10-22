<?php
session_start();

$senhaCorreta = $_SESSION['senha']; 

if (isset($_POST['senha']) && $_POST['senha'] === $senhaCorreta) {
    echo 'senha correta';
} else {
    echo 'senha incorreta';
}
?>
