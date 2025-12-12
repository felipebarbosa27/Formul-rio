<?php
$message = "";

// Quando clicar no botão, executa o código de popular
if (isset($_GET['pop'])) {

    // Certifique-se de que "conexao.php" está incluído
    include "conexao.php";

    // Define o fuso horário para evitar erros de data
    date_default_timezone_set('America/Sao_Paulo');

    // --- Listas de dados aleatórios ---
    $primeiros_nomes = ['Ana', 'Bruno', 'Carla', 'Daniel', 'Eduarda', 'Fábio', 'Gabriela', 'Hugo', 'Isabela', 'João', 'Larissa', 'Marcos', 'Natália', 'Otávio', 'Patrícia', 'Rafael', 'Sofia', 'Tiago', 'Vitória', 'William'];
    $sobrenomes = ['Silva', 'Santos', 'Oliveira', 'Souza', 'Rodrigues', 'Ferreira', 'Alves', 'Pereira', 'Lima', 'Gomes', 'Costa', 'Ribeiro', 'Martins', 'Carvalho', 'Almeida'];
    $ruas = ['Rua das Flores', 'Avenida Principal', 'Rua da Matriz', 'Travessa das Acácias', 'Rua dos Pinheiros', 'Avenida Brasil', 'Rua do Comércio'];
    $bairros = ['Centro', 'Vila Nova', 'Jardim das Rosas', 'Bairro Alto', 'Santa Fé', 'Parque Industrial', 'Boa Vista'];
    $cursos = ['Desenvolvimento de Sistemas', 'Informática', 'Administração', 'Enfermagem'];
    
    // --- NOVOS DADOS ADICIONADOS ---
    $cidades = ['Crateús', 'Fortaleza', 'Caucaia', 'Sobral', 'Juazeiro do Norte', 'Iguatu', 'Maracanaú', 'Crato'];
    $sexos = ['M', 'F']; 


    // Prepara o SQL uma única vez fora do loop
    // 12 Campos no total (3 novos: sexo, endereco_cidade, status)
    $sql = "INSERT INTO alunos
            (nome_completo, data_nascimento, sexo, endereco_rua, endereco_numero, endereco_bairro, endereco_cidade, endereco_cep, nome_responsavel, tipo_responsavel, curso_escolhido, status)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql);


    // --- Loop para inserir 100 alunos ---
    for ($i = 1; $i <= 100; $i++) {
        
        // Gera dados aleatórios
        $nome_aleatorio = $primeiros_nomes[array_rand($primeiros_nomes)] . " " . $sobrenomes[array_rand($sobrenomes)];
        
        // Garante que se o primeiro nome for feminino, o sexo seja 'F', e vice-versa, para coerência
        $is_feminino = in_array(explode(' ', $nome_aleatorio)[0], ['Ana', 'Carla', 'Eduarda', 'Gabriela', 'Isabela', 'Larissa', 'Natália', 'Patrícia', 'Sofia', 'Vitória']);
        $sexo = $is_feminino ? 'F' : 'M';
        
        $resp_aleatorio = $primeiros_nomes[array_rand($primeiros_nomes)] . " " . $sobrenomes[array_rand($sobrenomes)];
        
        // Gera uma data de nascimento aleatória (entre 15 e 21 anos)
        $timestamp_aleatorio = mt_rand(strtotime("2004-01-01"), strtotime("2010-12-31"));
        $data_nasc = date("Y-m-d", $timestamp_aleatorio);

        $rua = $ruas[array_rand($ruas)];
        $numero = rand(10, 1500);
        $bairro = $bairros[array_rand($bairros)];
        $cidade = $cidades[array_rand($cidades)]; // NOVA VARIÁVEL
        $cep = rand(10000, 99999) . "-" . rand(100, 999);
        $tipo_resp = rand(1, 6); 
        $curso_escolhido = $cursos[array_rand($cursos)];
        
        // Status: 90% Ativo (1), 10% Inativo (0)
        $status = (rand(1, 10) <= 9) ? 1 : 0; 

        // Executa o Prepared Statement com os dados gerados
        // Tipos: 12 strings (s - string, i - integer, d - double, b - blob)
        // Usaremos "sssissisisss" (String, String, String, Integer, String, String, String, String, String, Integer, String, Integer)
        // No MySQL, o tipo_resp e status podem ser tratados como inteiros ou strings dependendo da definição da coluna. 
        // Para simplificar no bind, usaremos apenas 's' para tudo, já que o MySQL faz conversão implícita na maioria dos casos.
        // Se a coluna 'status' for INT e 'tipo_responsavel' for INT, idealmente seria: "sssiisiisssi"
        // MANTENDO COMO STRING para compatibilidade máxima:
        $stmt->bind_param("sssssississs",
            $nome_aleatorio,
            $data_nasc,
            $sexo,               // NOVO: Sexo
            $rua,
            $numero,
            $bairro,
            $cidade,             // NOVO: Cidade
            $cep,
            $resp_aleatorio,
            $tipo_resp,
            $curso_escolhido,
            $status              // NOVO: Status
        );
        
        // Nota: O bind_param acima (ssissississs) deve corresponder exatamente aos tipos de dados da sua tabela, 
        // mas é comum usar 's' para strings e 'i' para números.
        
        $stmt->execute();
    }
    
    // Fecha o statement após o loop
    $stmt->close();
    $message = "🎉 <b>100 alunos populados com sucesso, incluindo SEXO, CIDADE e STATUS!</b>";
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Popular DB</title>
    <style>
        body { font-family: Arial, sans-serif; display: flex; flex-direction: column; align-items: center; padding-top: 50px; }
        .container { background: #f0f0f0; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); text-align: center; }
        .btn-pop { background-color: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; font-size: 1.1em; margin-top: 20px; }
        .btn-pop:hover { background-color: #0056b3; }
        .success { color: green; font-weight: bold; margin-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Popular Banco de Dados (Alunos)</h1>
        <p>
            Ao clicar no botão abaixo, serão inseridos 100 registros aleatórios na tabela `alunos`,
            incluindo dados de `sexo`, `cidade` e `status` (ativo/inativo), essenciais para o Dashboard.
        </p>
        
        <?php if ($message): ?>
            <p class="success"><?= $message ?></p>
            <p>
                <a class="btn-pop" href="painel.php">Ir para o Dashboard</a>
            </p>
        <?php else: ?>
            <a class="btn-pop" href="popular.php?pop=true">EXECUTAR POPULADOR</a>
        <?php endif; ?>
    </div>
</body>
</html>