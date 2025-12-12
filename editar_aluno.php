<?php
include "conexao.php";
// O include "painel.php" é opcional aqui, mas necessário se usar as funções de tradução
include "painel.php"; 

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID inválido.");
}

$id_aluno = intval($_GET['id']);
$erro = null;

// Salvar alterações (Movemos o processamento POST para o início, antes da exibição do HTML)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Obter e sanitizar dados
    $nome_completo = $_POST['nome_completo'];
    $data_nascimento = $_POST['data_nascimento'];
    $endereco_rua = $_POST['endereco_rua'];
    $endereco_numero = $_POST['endereco_numero'];
    $endereco_bairro = $_POST['endereco_bairro'];
    $endereco_cep = $_POST['endereco_cep'];
    $nome_responsavel = $_POST['nome_responsavel'];
    $tipo_responsavel = $_POST['tipo_responsavel'];
    $curso_escolhido = $_POST['curso_escolhido'];
    $id_aluno_post = $_POST['id_aluno']; // Garantir que o ID não mude

    // 2. Salvar alterações (UPDATE com Prepared Statement)
    $sql = "
        UPDATE alunos SET
            nome_completo = ?,
            data_nascimento = ?,
            endereco_rua = ?,
            endereco_numero = ?,
            endereco_bairro = ?,
            endereco_cep = ?,
            nome_responsavel = ?,
            tipo_responsavel = ?,
            curso_escolhido = ?
        WHERE id_aluno = ?
    ";

    $stmt_update = $conexao->prepare($sql);
    // Tipos: 9 strings (sssssssss) e 1 integer (i) para o ID no WHERE
    $stmt_update->bind_param("sssssssssi",
        $nome_completo,
        $data_nascimento,
        $endereco_rua,
        $endereco_numero,
        $endereco_bairro,
        $endereco_cep,
        $nome_responsavel,
        $tipo_responsavel,
        $curso_escolhido,
        $id_aluno_post
    );

    if ($stmt_update->execute()) {
        $stmt_update->close();
        // Redireciona para alunos.php com mensagem de sucesso
        header("Location: alunos.php?status=sucesso"); 
        exit;
    } else {
        $erro = "Erro ao atualizar: " . $stmt_update->error;
        $stmt_update->close();
        // Se houver erro, a página continua a ser carregada e exibe o formulário
    }
}

// 3. Buscar dados do aluno para exibir o formulário (SELECT com Prepared Statement)
$stmt_select = $conexao->prepare("SELECT * FROM alunos WHERE id_aluno = ?");
$stmt_select->bind_param("i", $id_aluno);
$stmt_select->execute();
$query = $stmt_select->get_result();

if ($query->num_rows === 0) {
    die("Aluno não encontrado.");
}

$aluno = $query->fetch_assoc();
$stmt_select->close();

// Definições de estilo (para um visual consistente)
$cursos_disponiveis = [
    "Desenvolvimento de Sistemas" => "Desenvolvimento de Sistemas",
    "Informática" => "Informática",
    "Administração" => "Administração",
    "Enfermagem" => "Enfermagem"
];
$tipos_responsavel = [
    1 => "Pai/Mãe", 
    2 => "Avô/Avó", 
    3 => "Tio/Tia", 
    4 => "Irmão/Irmã", 
    5 => "Primo/Prima", 
    6 => "Outro"
];

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Editar Aluno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<section class="h-100 mt-5">
    <div class="container h-100">
        <div class="row justify-content-sm-center h-100">
            <div class="col-xxl-6 col-xl-6 col-lg-7 col-md-9 col-sm-11">
                
                <div class="card shadow-lg">
                    <div class="card-body p-5">
                        <h1 class="fs-4 card-title fw-bold mb-4">Editar Aluno: <?= htmlspecialchars($aluno['nome_completo']) ?></h1>

                        <?php if ($erro): ?>
                            <div class="alert alert-danger"><?= $erro ?></div>
                        <?php endif; ?>

                        <form action="editar_aluno.php?id=<?= $id_aluno ?>" method="POST" class="needs-validation" novalidate>
                            
                            <input type="hidden" name="id_aluno" value="<?= $id_aluno ?>">

                            <div class="mb-3">
                                <label class="mb-2 text-muted">Nome completo</label>
                                <input type="text" class="form-control" name="nome_completo" value="<?= htmlspecialchars($aluno['nome_completo']) ?>" required>
                                <div class="invalid-feedback">Campo obrigatório</div>
                            </div>

                            <div class="mb-3">
                                <label class="mb-2 text-muted">Data de nascimento</label>
                                <input type="date" class="form-control" name="data_nascimento" value="<?= htmlspecialchars($aluno['data_nascimento']) ?>" required>
                                <div class="invalid-feedback">Campo obrigatório</div>
                            </div>

                            <h5 class="fw-bold mt-4">Endereço</h5>

                            <div class="mb-3">
                                <label class="mb-2 text-muted">Rua</label>
                                <input type="text" class="form-control" name="endereco_rua" value="<?= htmlspecialchars($aluno['endereco_rua']) ?>" required>
                                <div class="invalid-feedback">Campo obrigatório</div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="mb-2 text-muted">Número</label>
                                    <input type="text" class="form-control" name="endereco_numero" value="<?= htmlspecialchars($aluno['endereco_numero']) ?>" required>
                                </div>
                                <div class="col-md-8 mb-3">
                                    <label class="mb-2 text-muted">Bairro</label>
                                    <input type="text" class="form-control" name="endereco_bairro" value="<?= htmlspecialchars($aluno['endereco_bairro']) ?>" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="mb-2 text-muted">CEP</label>
                                <input type="text" class="form-control" name="endereco_cep" value="<?= htmlspecialchars($aluno['endereco_cep']) ?>" required>
                            </div>


                            <div class="mb-3">
                                <label class="mb-2 text-muted" for="nome_responsavel">Nome do responsável</label>
                                <input type="text" class="form-control" name="nome_responsavel" id="nome_responsavel" value="<?= htmlspecialchars($aluno['nome_responsavel']) ?>">
                            </div>
                            
                            <div class="mb-3 text-muted">
                                <label class="tipoResponsavel" for="tipoResponsavel">Tipo do responsável</label>
                                <br>
                                <select class="form-select" name="tipo_responsavel" id="tipoResponsavel" required>
                                    <option selected disabled value="">Selecione...</option>
                                    <?php foreach ($tipos_responsavel as $id => $nome): ?>
                                        <option value="<?= $id ?>" <?= ($aluno['tipo_responsavel'] == $id) ? 'selected' : '' ?>>
                                            <?= $nome ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div> 

                            <div class="mb-3">
                                <label class="mb-2 text-muted">Curso</label>
                                <select class="form-select" name="curso_escolhido" required>
                                    <option selected disabled value="">Selecione...</option>
                                    <?php foreach ($cursos_disponiveis as $valor => $nome_curso): ?>
                                        <option value="<?= $valor ?>" <?= ($aluno['curso_escolhido'] == $valor) ? 'selected' : '' ?>>
                                            <?= $nome_curso ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">Selecione um curso</div>
                            </div>

                            <div class="d-flex align-items-center">
                                <a href="alunos.php" class="btn btn-secondary me-3">Cancelar e Voltar</a>
                                <button type="submit" class="btn btn-primary ms-auto">Salvar Alterações</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>