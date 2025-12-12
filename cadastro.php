
<?php
session_start();
include('conexao.php');

// Validação de campos vazios
if(empty($_POST['nome']) || empty($_POST['email']) || empty($_POST['senha'])){
    $_SESSION['mensagem'] = "Preencha todos os campos!";
    header('Location: telacadastro.php');
    exit();
}

$nome = trim($_POST['nome']);
$email = trim($_POST['email']);
$senha = trim($_POST['senha']);

// 1. Verificar se já existe um usuário (SELECT com Prepared Statement)
$stmt_check = $conexao->prepare("SELECT count(*) as total FROM users WHERE user_email = ?");
$stmt_check->bind_param("s", $email);
$stmt_check->execute();
$result_check = $stmt_check->get_result();
$row_check = $result_check->fetch_assoc();
$stmt_check->close();

if($row_check['total'] > 0){
    $_SESSION['mensagem'] = "E-mail já cadastrado!";
    header('Location: telacadastro.php');
    exit();
}

// 2. Inserir novo usuário (INSERT com Prepared Statement)
$sqlInserir = "INSERT INTO users(user_name, user_email, user_password) VALUES (?, ?, MD5(?))";

$stmt_insert = $conexao->prepare($sqlInserir);
$stmt_insert->bind_param("sss", $nome, $email, $senha);

if($stmt_insert->execute()){
    $stmt_insert->close();
    $_SESSION['mensagem'] = "Cadastro realizado com sucesso!";
    header('Location: index.php');
    exit();
}else{
    $erro_msg = "Erro ao cadastrar: " . $stmt_insert->error;
    $stmt_insert->close();
    $_SESSION['mensagem'] = $erro_msg;
    header('Location: telacadastro.php');
    exit();
}
?>