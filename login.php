<?php
session_start();
include('conexao.php');

if (empty($_POST['email']) || empty($_POST['senha'])) {
    header('Location: index.php');
    exit();
}

$email = $_POST['email'];
$senha = $_POST['senha'];

// USANDO PREPARED STATEMENT
$query = "SELECT user_id, user_email FROM users WHERE user_email = ? AND user_password = MD5(?)";

$stmt = $conexao->prepare($query);

if (!$stmt) {
    die("Erro ao preparar a consulta: " . $conexao->error);
}

$stmt->bind_param("ss", $email, $senha);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->num_rows;

if ($row == 1) {
    $_SESSION['email'] = $email;
    $stmt->close();
    header('Location: painel.php');
    exit();
} else {
    $_SESSION['nao_autenticado'] = true;
    $stmt->close();
    header('Location: index.php');
    exit();
}
?>