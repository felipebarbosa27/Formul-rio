<?php
// Arquivo: funcoes.php - Contém apenas as funções que não dependem das colunas problemáticas

// --- Funções de Mapeamento (Tradução) ---

function nomeCurso($curso_escolhido) {
    $cursos_map = [
        "Desenvolvimento de Sistemas" => "Desenvolvimento de Sistemas",
        "Informática" => "Informática",
        "Administração" => "Administração",
        "Enfermagem" => "Enfermagem"
    ];
    return $cursos_map[$curso_escolhido] ?? $curso_escolhido;
}

function nomeResponsavelTipo($id) {
    $tipos = [
        1 => "Pai/Mãe",
        2 => "Avô/Avó",
        3 => "Tio/Tia",
        4 => "Irmão/Irmã",
        5 => "Primo/Prima",
        6 => "Outro"
    ];
    return $tipos[intval($id)] ?? 'N/A';
}

// --- Funções de Cálculo (Para o Dashboard/Painel) ---

/**
 * Calcula a média de idade dos alunos. (VERIFICADO CONTRA ERRO)
 */
function calcularMediaIdade($conexao) {
    $hoje = new DateTime();
    $soma_idades = 0;
    $total_alunos = 0;

    // Assumimos que 'data_nascimento' existe, mas a verificação impede o erro fatal.
    $query = mysqli_query($conexao, "SELECT data_nascimento FROM alunos");

    if ($query) { 
        while ($aluno = mysqli_fetch_assoc($query)) {
            if ($aluno['data_nascimento'] && $aluno['data_nascimento'] != '0000-00-00') {
                try {
                    $data_nascimento = new DateTime($aluno['data_nascimento']);
                    $idade = $data_nascimento->diff($hoje)->y;
                    $soma_idades += $idade;
                    $total_alunos++;
                } catch (Exception $e) {}
            }
        }
    }

    if ($total_alunos > 0) {
        return round($soma_idades / $total_alunos);
    }
    return 0;
}

/**
 * Encontra o bairro com o maior número de alunos. (VERIFICADO CONTRA ERRO)
 */
function pegarBairroTop($conexao) {
    $query = mysqli_query($conexao, "
        SELECT endereco_bairro, COUNT(*) AS total_bairro 
        FROM alunos 
        GROUP BY endereco_bairro 
        ORDER BY total_bairro DESC 
        LIMIT 1
    ");
    
    if ($query && mysqli_num_rows($query) > 0) { 
        return mysqli_fetch_assoc($query)['endereco_bairro'];
    }
    return 'N/A';
}

/**
 * Retorna os dados para um gráfico simples de contagem por curso. (VERIFICADO CONTRA ERRO)
 */
function getDadosCursos($conexao) {
    $dados = [];
    $query = mysqli_query($conexao, "
        SELECT curso_escolhido, COUNT(*) AS total 
        FROM alunos 
        GROUP BY curso_escolhido 
        ORDER BY total DESC
    ");
    
    if ($query) { 
        while ($row = mysqli_fetch_assoc($query)) {
            $dados[] = $row;
        }
    }
    return $dados;
}

/**
 * Calcula o total de cursos distintos cadastrados. (VERIFICADO CONTRA ERRO)
 */
function getTotalCursos($conexao) {
    $query = mysqli_query($conexao, "SELECT COUNT(DISTINCT curso_escolhido) AS total_cursos FROM alunos");
    
    if ($query) { 
        return mysqli_fetch_assoc($query)['total_cursos'] ?? 0;
    }
    return 0;
}

/**
 * Calcula a média de alunos por curso. (VERIFICADO CONTRA ERRO)
 */
function getMediaAlunosPorCurso($conexao) {
    $total_alunos_query = mysqli_query($conexao, "SELECT COUNT(*) AS total_alunos FROM alunos");
    $total_cursos_query = mysqli_query($conexao, "SELECT COUNT(DISTINCT curso_escolhido) AS total_cursos FROM alunos");
    
    $total_alunos = 0;
    $total_cursos = 0;

    if ($total_alunos_query) {
        $total_alunos = mysqli_fetch_assoc($total_alunos_query)['total_alunos'] ?? 0;
    }
    
    if ($total_cursos_query) {
        $total_cursos = mysqli_fetch_assoc($total_cursos_query)['total_cursos'] ?? 0;
    }

    if ($total_cursos > 0 && $total_alunos > 0) {
        return number_format($total_alunos / $total_cursos, 2);
    }
    return 0;
}
?>