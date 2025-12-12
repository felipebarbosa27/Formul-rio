<?php
// Arquivo: painel.php (Dashboard / HOME) - Versão estável com Tema

include_once "conexao.php"; 
include_once "funcoes.php"; 

// ===============================================
// Lógica de Estatísticas e Consultas (ESTÁVEIS)
// ===============================================

// 1. Total de Alunos
$query_total = mysqli_query($conexao, "SELECT COUNT(*) AS total FROM alunos");
$total_alunos = mysqli_fetch_assoc($query_total)['total'] ?? 0;

// 2. Média de Idade
$media_idade = calcularMediaIdade($conexao);

// 3. Bairro Top
$bairro_top = pegarBairroTop($conexao);

// 4. Tipo de Responsável Top
$query_tipos = mysqli_query($conexao, "
    SELECT tipo_responsavel, COUNT(*) AS total 
    FROM alunos 
    GROUP BY tipo_responsavel 
    ORDER BY total DESC 
    LIMIT 1
");
$tipo_responsavel_top_id = mysqli_fetch_assoc($query_tipos)['tipo_responsavel'] ?? 0;
$tipo_responsavel_top_nome = nomeResponsavelTipo($tipo_responsavel_top_id);

// 5. Total de Cursos Distintos
$total_cursos = getTotalCursos($conexao);

// 6. Média de Alunos por Curso
$media_alunos_por_curso = getMediaAlunosPorCurso($conexao);

// 7. Dados para Gráfico de Cursos
$dados_cursos = getDadosCursos($conexao);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dashboard - HOME</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script> 
<style>
/* Cores base */
:root {
    --cor-principal: #007bff;
    --cor-destaque-primaria: #003366; 
    --cor-fundo-claro: #f8f9fa;
    --cor-fundo-escuro: #212529; /* Cor de fundo para modo escuro */
    --cor-texto-claro: #212529;  /* Cor do texto para modo claro */
    --cor-texto-escuro: #f8f9fa; /* Cor do texto para modo escuro */
    --cor-card-claro: #ffffff;
    --cor-card-escuro: #343a40;
}

/* Modo Claro (Padrão) */
body { 
    background-color: var(--cor-fundo-claro); 
    color: var(--cor-texto-claro);
    transition: background-color 0.3s, color 0.3s;
}
.navbar { 
    background-color: var(--cor-card-claro) !important; 
    border-bottom: 3px solid var(--cor-destaque-primaria); 
    transition: background-color 0.3s;
}
.card {
    background-color: var(--cor-card-claro);
    color: var(--cor-texto-claro);
    transition: background-color 0.3s, color 0.3s;
}
.nav-link { 
    color: var(--cor-destaque-primaria) !important; 
    font-weight: 500; 
}

/* Modo Escuro (Aplicado quando a classe .dark-mode está no body) */
body.dark-mode {
    background-color: var(--cor-fundo-escuro);
    color: var(--cor-texto-escuro);
}
body.dark-mode .navbar {
    background-color: var(--cor-card-escuro) !important;
}
body.dark-mode .navbar .nav-link, 
body.dark-mode .navbar-brand {
    color: var(--cor-texto-escuro) !important; 
}
body.dark-mode .card {
    background-color: var(--cor-card-escuro);
    color: var(--cor-texto-escuro);
}
body.dark-mode .card-metric .text-muted {
    color: #adb5bd !important; /* Cor de texto suave no modo escuro */
}

/* Estilos dos Cards */
.card-metric { border-left: 5px solid var(--cor-principal); }
.card-metric.green-border { border-left-color: #28a745; } 
.card-metric.red-border { border-left-color: #dc3545; } 
.card-metric.orange-border { border-left-color: #ffc107; } 
.card-metric.purple-border { border-left-color: #6f42c1; } 
.metric-value { font-size: 2.5rem; font-weight: bold; }
</style>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white mb-4 shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="painel.php"> Dashboard </a>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link active" href="painel.php"> Home</a></li>
        <li class="nav-item"><a class="nav-link" href="alunos.php"> Alunos</a></li>
        <li class="nav-item"><a class="nav-link" href="cadastro.php"> + Novo Cadastro</a></li> 
      </ul>
      <ul class="navbar-nav align-items-center">
        <li class="nav-item me-3">
            <button id="theme-toggle" class="btn btn-sm btn-outline-secondary" title="Alternar Modo Claro/Escuro">
                <i class="bi bi-moon-fill" id="theme-icon"></i>
            </button>
        </li>
        <li class="nav-item">
            <a class="nav-link btn btn-sm btn-danger" href="logout.php"> Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container">
    <h2 class="mb-4">Estatísticas do Sistema (Dashboard)</h2>

    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card p-3 shadow-sm card-metric">
                <p class="text-muted mb-0">Total Geral de Alunos</p>
                <div class="metric-value text-primary"><?= $total_alunos ?></div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card p-3 shadow-sm card-metric green-border">
                <p class="text-muted mb-0">Média de Idade</p>
                <div class="metric-value text-success"><?= $media_idade ?> anos</div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card p-3 shadow-sm card-metric orange-border">
                <p class="text-muted mb-0">Total de Cursos</p>
                <div class="metric-value text-info"><?= $total_cursos ?></div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card p-3 shadow-sm card-metric red-border">
                <p class="text-muted mb-0">Média Alunos/Curso</p>
                <div class="metric-value text-danger"><?= $media_alunos_por_curso ?></div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card p-3 shadow-sm card-metric purple-border">
                <p class="text-muted mb-0">Bairro com Mais Alunos</p>
                <div class="metric-value text-warning" style="font-size: 2rem;"><?= htmlspecialchars($bairro_top) ?></div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card p-3 shadow-sm card-metric">
                <p class="text-muted mb-0">Tipo de Resp. Mais Comum</p>
                <div class="metric-value text-primary" style="font-size: 2rem;"><?= htmlspecialchars($tipo_responsavel_top_nome) ?></div>
            </div>
        </div>
    </div>
    
    <div class="row mt-3">
        <div class="col-md-6 offset-md-3 mb-4">
            <div class="card p-4 shadow-sm h-100">
                <h4>📊 Alunos Matriculados por Curso</h4>
                <div style="height: 350px;">
                    <canvas id="graficoCursos"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    // Lógica para alternar o tema (Modo Claro/Escuro)
    const toggleButton = document.getElementById('theme-toggle');
    const body = document.body;
    const icon = document.getElementById('theme-icon');
    const navbar = document.querySelector('.navbar');

    // 1. Carregar tema salvo ou usar o padrão (claro)
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
        applyTheme('dark');
    } else {
        applyTheme('light');
    }

    function applyTheme(theme) {
        if (theme === 'dark') {
            body.classList.add('dark-mode');
            navbar.classList.remove('navbar-light', 'bg-white');
            navbar.classList.add('navbar-dark');
            icon.classList.remove('bi-moon-fill');
            icon.classList.add('bi-sun-fill');
        } else {
            body.classList.remove('dark-mode');
            navbar.classList.remove('navbar-dark');
            navbar.classList.add('navbar-light', 'bg-white');
            icon.classList.remove('bi-sun-fill');
            icon.classList.add('bi-moon-fill');
        }
    }

    // 2. Alternar tema ao clicar
    toggleButton.addEventListener('click', () => {
        if (body.classList.contains('dark-mode')) {
            applyTheme('light');
            localStorage.setItem('theme', 'light');
        } else {
            applyTheme('dark');
            localStorage.setItem('theme', 'dark');
        }
    });

    // ------------------------------------
    // Gráfico de Cursos (Barras)
    // ------------------------------------
    const dadosCursos = <?= json_encode($dados_cursos) ?>;

    const labelsCursos = dadosCursos.map(d => d.curso_escolhido);
    const dataCountsCursos = dadosCursos.map(d => d.total);

    const ctxCursos = document.getElementById('graficoCursos').getContext('2d');
    new Chart(ctxCursos, {
        type: 'bar', 
        data: {
            labels: labelsCursos,
            datasets: [{
                label: 'Total de Alunos',
                data: dataCountsCursos,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.8)', 
                    'rgba(54, 162, 235, 0.8)', 
                    'rgba(255, 206, 86, 0.8)', 
                    'rgba(75, 192, 192, 0.8)', 
                    'rgba(153, 102, 255, 0.8)', 
                    'rgba(255, 159, 64, 0.8)', 
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 }
                }
            }
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>