<?php
session_start();
include('conexao.php');

// 1. Coleta de dados do formulário (cadastro2.php)
$nome_completo = trim($_POST['nome_completo']);
$data_nascimento = $_POST['data_nascimento'];
$endereco_rua = trim($_POST['endereco_rua']);
$endereco_numero = trim($_POST['endereco_numero']);
$endereco_bairro = trim($_POST['endereco_bairro']);
$endereco_cep = trim($_POST['endereco_cep']);
$nome_responsavel = trim($_POST['nome_responsavel']);
$tipo_responsavel = trim($_POST['tipo_responsavel']);
$curso_escolhido = trim($_POST['curso_escolhido']);

// 2. Validação básica (opcional, mas recomendado)
if (empty($nome_completo) || empty($curso_escolhido)) {
    $_SESSION['erro'] = "Nome completo e Curso são obrigatórios!";
    header('Location: cadastro2.php');
    exit();
}

// 3. INSERT com Prepared Statement (Tabela: alunos)
$sqlInserir = "
    INSERT INTO alunos
    (nome_completo, data_nascimento, endereco_rua, endereco_numero, endereco_bairro, endereco_cep, nome_responsavel, tipo_responsavel, curso_escolhido)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
";

$stmt = $conexao->prepare($sqlInserir);

// Tipos: 9 strings
$stmt->bind_param("sssssssss",
    $nome_completo,
    $data_nascimento,
    $endereco_rua,
    $endereco_numero,
    $endereco_bairro,
    $endereco_cep,
    $nome_responsavel,
    $tipo_responsavel,
    $curso_escolhido
);

if ($stmt->execute()) {
    $stmt->close();
    $_SESSION['mensagem'] = "Aluno cadastrado com sucesso!";
    header('Location: alunos.php');
    exit();
} else {
    $erro_msg = "Erro ao cadastrar aluno: " . $stmt->error;
    $stmt->close();
    $_SESSION['erro'] = $erro_msg;
    header('Location: cadastro2.php');
    exit();
}

?>
