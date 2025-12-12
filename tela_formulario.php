<?php
session_start();
// Se você precisar incluir a conexão ou funções aqui, adicione as linhas abaixo:
// include_once "conexao.php"; 
// include_once "funcoes.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Cadastrar Aluno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --cor-principal: #007bff;
            --cor-destaque-primaria: #003366; 
        }
        body { 
            background-color: #f8f9fa; 
        }
        /* Estilos da Navbar (Copiados do painel.php para padronização) */
        .navbar { 
            background-color: #ffffff !important; 
            border-bottom: 3px solid var(--cor-destaque-primaria); 
        }
        .nav-link { 
            color: var(--cor-destaque-primaria) !important; 
            font-weight: 500; 
        }
        .nav-item .active {
             /* Define o link 'Novo Cadastro' como ativo nesta página */
            font-weight: bold;
        }
    </style>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white mb-4 shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="painel.php"> Dashboard </a>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="painel.php"> Home</a></li>
        <li class="nav-item"><a class="nav-link" href="alunos.php"> Alunos</a></li>
        <li class="nav-item"><a class="nav-link active" href="cadastro.php"> + Novo Cadastro</a></li> 
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link btn btn-sm btn-danger" href="logout.php"> Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<section class="h-100">
    <div class="container h-100">
        <div class="row justify-content-sm-center h-100">
            <div class="col-xxl-6 col-xl-6 col-lg-7 col-md-9 col-sm-11">
                
                <div class="card shadow-lg my-5"> 
                    <div class="card-body p-5">
                        
                        <div class="text-center">
<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor" class="bi bi-lightning" viewBox="0 0 16 16">
  <path d="M5.52.359A.5.5 0 0 1 6 0h4a.5.5 0 0 1 .474.658L8.694 6H12.5a.5.5 0 0 1 .395.807l-7 9a.5.5 0 0 1-.873-.454L6.823 9.5H3.5a.5.5 0 0 1-.48-.641zM6.374 1 4.168 8.5H7.5a.5.5 0 0 1 .478.647L6.78 13.04 11.478 7H8a.5.5 0 0 1-.474-.658L9.306 1z"/>
</svg>                     </div>

                        <h1 class="fs-4 card-title fw-bold mb-4 text-center">Cadastrar Aluno</h1>

                        <form action="salvar.php" method="POST" class="needs-validation" novalidate>

                            <div class="mb-3">
                                <label class="mb-2 text-muted" for="nome_completo">Nome completo</label>
                                <input type="text" class="form-control" name="nome_completo" id="nome_completo" placeholder="Digite o nome completo" required>
                                <div class="invalid-feedback">Campo obrigatório</div>
                            </div>

                            
                            <div class="mb-3">
                                <label class="mb-2 text-muted" for="data_nascimento">Data de nascimento</label>
                                <input type="date" class="form-control" name="data_nascimento" id="data_nascimento" required>
                                <div class="invalid-feedback">Campo obrigatório</div>
                            </div>

                            <fieldset class="border p-3 rounded mb-3">
                                <legend class="float-none w-auto fs-6 fw-bold px-2">Endereço</legend>

                                <div class="mb-3">
                                    <label class="mb-2 text-muted" for="rua">Rua</label>
                                    <input type="text" class="form-control" name="endereco_rua" id="endereco_rua" placeholder="Ex: Rua das Flores" required>
                                    <div class="invalid-feedback">Campo obrigatório</div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="mb-2 text-muted" for="numeroCasa">Número</label>
                                        <input type="text" class="form-control" name="endereco_numero" id="endereco_numero" placeholder="Ex: 123" required>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <label class="mb-2 text-muted" for="bairro">Bairro</label>
                                        <input type="text" class="form-control" name="endereco_bairro" id="endereco_bairro" placeholder="Ex: Centro" required>
                                        <div class="invalid-feedback">Campo obrigatório</div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="mb-2 text-muted" for="cidade">Cidade</label>
                                    <input type="text" class="form-control" name="endereco_cidade" id="endereco_cidade" placeholder="Ex: Crateús" required>
                                    <div class="invalid-feedback">Campo obrigatório</div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="mb-2 text-muted" for="cep">CEP</label>
                                    <input type="text" class="form-control" name="endereco_cep" id="endereco_cep" placeholder="00000-000" inputmode="numeric" pattern="\d{5}-?\d{3}" required>
                                    <div class="invalid-feedback">Por favor, insira um CEP válido.</div>
                                </div>
                            </fieldset>
                            
                            <div class="mb-3">
                                <label class="mb-2 text-muted" for="sexo">Sexo/Gênero</label>
                                <select class="form-select" name="sexo" id="sexo" required>
                                    <option selected disabled value="">Selecione...</option>
                                    <option value="M">Masculino</option>
                                    <option value="F">Feminino</option>
                                    <option value="O">Outro/Não Informar</option>
                                </select>
                                <div class="invalid-feedback">Selecione o sexo/gênero.</div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="mb-2 text-muted" for="nome_responsavel">Nome completo do responsável</label>
                                <input type="text" class="form-control" name="nome_responsavel" id="nome_responsavel" placeholder="Nome do responsável: " required>
                                <div class="invalid-feedback">Campo obrigatório</div>
                            </div>
                            
                            
                            <div class="mb-3 text-muted">
                                <label class="tipoResponsavel" for="tipoResponsavel">Tipo do responsável</label>
                                <br>
                                <select class="form-select" name="tipoResponsavel" id="tipoResponsavel" required>
                                <option selected disabled value="">Selecione...</option>
                                <option value="1">Pai/Mãe</option>
                                <option value="2">Avô/Avó</option>
                                <option value="3">Tio/Tia</option>
                                <option value="4">Irmão/Irmã</option>
                                <option value="5">Primo/Prima</option>
                                <option value="6">Outro</option>
                                </select>
                            </div> 

                            
                            <div class="mb-3">
                                <label class="mb-2 text-muted" for="curso">Curso</label>
                                <select class="form-select" name="curso_escolhido" id="curso_escolhido" required>
                                    <option selected disabled value="">Selecione...</option>
                                    <option value="ds">Desenvolvimento de Sistemas</option>
                                    <option value="informatica">Informática</option>
                                    <option value="adm">Administração</option>
                                    <option value="enfermagem">Enfermagem</option>
                                </select>
                                <div class="invalid-feedback">Selecione um curso</div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="mb-2 text-muted" for="status">Status do Aluno</label>
                                <select class="form-select" name="status" id="status" required>
                                    <option value="1" selected>Ativo</option>
                                    <option value="0">Inativo / Trancado</option>
                                </select>
                            </div>

                            
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <a href="painel.php" class="btn btn-outline-secondary">Voltar ao Painel</a>
                                <button type="submit" class="btn btn-primary">Cadastrar</button>
                            </div>

                        </form>
                    </div>
                </div>

                <div class="text-center mt-5 mb-4 text-muted">
                    Copyright &copy; 2025 — Seu Sistema
                </div>

            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>