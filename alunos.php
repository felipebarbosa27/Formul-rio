<?php
// Arquivo: alunos.php (Apenas Listagem)

include_once "conexao.php"; 
include_once "funcoes.php"; // Inclui as funções de tradução (nomeCurso, nomeResponsavelTipo)

// ===============================================
// Lógica de Paginação
// ===============================================
$limite_por_pagina = 10;
$pagina_atual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($pagina_atual - 1) * $limite_por_pagina;

// 1. Contar o total de registros
$total_registros_q = mysqli_query($conexao, "SELECT COUNT(*) AS total FROM alunos");
$total_registros = mysqli_fetch_assoc($total_registros_q)['total'] ?? 0;
$total_paginas = ceil($total_registros / $limite_por_pagina);

// 2. Consulta dos alunos para listagem
$query_alunos = "SELECT * FROM alunos ORDER BY nome_completo ASC LIMIT $limite_por_pagina OFFSET $offset";
$alunos = mysqli_query($conexao, $query_alunos);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Lista de Alunos </title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
/* Estilos replicados do seu painel.php para consistência */
:root {
    --cor-principal: #007bff;
    --cor-destaque-primaria: #003366; 
}
body { background-color: var(--cor-fundo-suave); }
.navbar { background-color: #ffffff !important; border-bottom: 3px solid var(--cor-destaque-primaria); }
.nav-link { color: var(--cor-destaque-primaria) !important; font-weight: 500; }
.table th { background-color: var(--cor-destaque-primaria); color: white; }
.table-striped>tbody>tr:nth-of-type(odd){ background-color: #e9ecef; }
</style>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white mb-4 shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="painel.php"> Dashboard </a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="painel.php"> Home</a></li>
        <li class="nav-item"><a class="nav-link active" href="alunos.php"> Alunos</a></li>
        <li class="nav-item"><a class="nav-link" href="tela_formulario.php"> + Novo Cadastro</a></li> 
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link btn btn-sm btn-danger" href="logout.php"> Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container">

  <h2 class="mb-4">Lista Completa de Alunos (Total: <?= $total_registros ?>)</h2>
  
  <?php if (isset($_GET['status']) && $_GET['status'] == 'sucesso'): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
          Aluno atualizado com sucesso!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
  <?php endif; ?>

  <?php if ($total_registros > 0): ?>
  <div class="card p-3 shadow-sm">
    <div class="table-responsive">
      <table class="table table-striped table-hover align-middle">
        <thead>
          <tr>
            <th>Nome</th>
            <th>Nascimento</th>
            <th>Curso</th>
            <th>Responsável</th>
            <th>Tipo</th>
            <th>Bairro</th>
            <th>Ações</th> 
          </tr>
        </thead>
        <tbody>
          <?php while($row = mysqli_fetch_assoc($alunos)): ?>
          <tr>
            <td><?= htmlspecialchars($row['nome_completo']) ?></td>
            <td><?= date('d/m/Y', strtotime($row['data_nascimento'])) ?></td>
            <td><?= htmlspecialchars(nomeCurso($row['curso_escolhido'])) ?></td> 
            <td><?= htmlspecialchars($row['nome_responsavel']) ?></td>
            <td><?= htmlspecialchars(nomeResponsavelTipo($row['tipo_responsavel'])) ?></td>
            <td><?= htmlspecialchars($row['endereco_bairro']) ?></td>
            <td>
                <a href="editar_aluno.php?id=<?= $row['id_aluno'] ?>" class="btn btn-sm btn-primary">Editar</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>

  <nav aria-label="Navegação de página" class="mt-4">
    <ul class="pagination justify-content-center">
      <?php if ($pagina_atual > 1): ?>
        <li class="page-item"><a class="page-link" href="alunos.php?pagina=<?= $pagina_atual - 1 ?>">Anterior</a></li>
      <?php endif; ?>

      <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
        <li class="page-item <?= ($i == $pagina_atual) ? 'active' : '' ?>">
          <a class="page-link" href="alunos.php?pagina=<?= $i ?>"><?= $i ?></a>
        </li>
      <?php endfor; ?>

      <?php if ($pagina_atual < $total_paginas): ?>
        <li class="page-item"><a class="page-link" href="alunos.php?pagina=<?= $pagina_atual + 1 ?>">Próxima</a></li>
      <?php endif; ?>
    </ul>
  </nav>

  <?php else: ?>
  <div class="alert alert-warning text-center">
      Nenhum aluno encontrado no banco de dados.
  </div>
  <?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>