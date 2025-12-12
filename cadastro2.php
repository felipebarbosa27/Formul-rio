<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Cadastro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<section class="h-100">
    <div class="container h-100">
        <div class="row justify-content-sm-center h-100">
            <div class="col-xxl-6 col-xl-6 col-lg-7 col-md-9 col-sm-11">
               

                <div class="card shadow-lg">

                <div class="text-center">
                    <img src="image.png" width="100px" height="100px">
                </div>
                    <div class="card-body p-5">
                        <h1 class="fs-4 card-title fw-bold mb-4">Cadastrar Aluno</h1>

                        <form action="salvar.php" method="POST" class="needs-validation" novalidate>

                           
                            <div class="mb-3">
                                <label class="mb-2 text-muted">Nome completo</label>
                                <input type="text" class="form-control" name="nome_completo" required>
                                <div class="invalid-feedback">Campo obrigatório</div>
                            </div>

                       
                            <div class="mb-3">
                                <label class="mb-2 text-muted">Data de nascimento</label>
                                <input type="date" class="form-control" name="data_nascimento" required>
                                <div class="invalid-feedback">Campo obrigatório</div>
                            </div>

                            <h5 class="fw-bold mt-4">Endereço</h5>

                            <div class="mb-3">
                                <label class="mb-2 text-muted">Rua</label>
                                <input type="text" class="form-control" name="endereco_rua" required>
                                <div class="invalid-feedback">Campo obrigatório</div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="mb-2 text-muted">Número</label>
                                    <input type="text" class="form-control" name="endereco_numero" required>
                                </div>
                                <div class="col-md-8 mb-3">
                                    <label class="mb-2 text-muted">Bairro</label>
                                    <input type="text" class="form-control" name="endereco_bairro" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="mb-2 text-muted">CEP</label>
                                <input type="text" class="form-control" name="endereco_cep" required>
                            </div>


                              <div class="mb-3">
                                <label class="mb-2 text-muted" for="nome_responsavel">Nome do responsável</label>
                                <input type="text" class="form-control" name="nome_responsavel" id="nome_responsavel">
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
                                <label class="mb-2 text-muted">Curso</label>
                                <select class="form-select" name="curso_escolhido" required>
                                    <option selected disabled value="">Selecione...</option>
                                    <option value="Desenvolvimento de Sistemas">Desenvolvimento de Sistemas</option>
                                    <option value="Informática">Informática</option>
                                    <option value="Administração">Administração</option>
                                    <option value="Enfermagem">Enfermagem</option>
                                </select>
                                <div class="invalid-feedback">Selecione um curso</div>
                            </div>

                       
                            <div class="d-flex align-items-center">
                                <a href="index.php" class="btn btn-secondary me-3">Voltar</a>
                                <button type="submit" class="btn btn-primary ms-auto">Cadastrar</button>
                            </div>

                        </form>
                    </div>

                   

                </div>

                <div class="text-center mt-5 text-muted">
                    Copyright &copy; 2025 — Seu Sistema
                </div>

            </div>
        </div>
    </div>
</section>
</body>
</html>