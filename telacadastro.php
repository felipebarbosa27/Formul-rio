<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Login</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* Fundo levemente cinza */
        }
        .card {
            border: none; /* Remove borda */
            border-radius: 0.75rem; /* Bordas mais arredondadas */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.07); /* Sombra sutil */
        }
        /* Cor principal (Roxo/Azul) para botões */
        .btn-primary {
            background-color: #6f42c1;
            border-color: #6f42c1;
        }
        .btn-primary:hover {
            background-color: #5a379e;
            border-color: #5a379e;
        }
    </style>
</head>

<body>
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-sm-center h-100">
				<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
					
                    <div class="card shadow-lg" style="margin-top: 50px;">
                        
                        <div class="text-center pt-5">
<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor" class="bi bi-lightning" viewBox="0 0 16 16">
  <path d="M5.52.359A.5.5 0 0 1 6 0h4a.5.5 0 0 1 .474.658L8.694 6H12.5a.5.5 0 0 1 .395.807l-7 9a.5.5 0 0 1-.873-.454L6.823 9.5H3.5a.5.5 0 0 1-.48-.641zM6.374 1 4.168 8.5H7.5a.5.5 0 0 1 .478.647L6.78 13.04 11.478 7H8a.5.5 0 0 1-.474-.658L9.306 1z"/>
</svg>                        </div>

						<div class="card-body p-5">
							<h1 class="fs-4 card-title fw-bold mb-4 text-center">Login</h1>
                            
                            <?php if(isset($_SESSION['nao_autenticado'])): ?>
                            <div class="alert alert-danger" role="alert">
                                ERRO: E-mail ou senha inválidos.
                            </div>
                            <?php 
                                unset($_SESSION['nao_autenticado']);
                                endif; 
                            ?>
                            <?php if(isset($_SESSION['mensagem'])): ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo $_SESSION['mensagem']; ?>
                            </div>
                            <?php 
                                unset($_SESSION['mensagem']);
                                endif; 
                            ?>

							<form action="login.php" method="POST" class="needs-validation" novalidate="" autocomplete="off">
								<div class="mb-3">
									<label class="mb-2 text-muted" for="email">E-mail</label>
									<input id="email" type="email" class="form-control" name="email" required autofocus>
									<div class="invalid-feedback">
										E-mail inválido
									</div>
								</div>

								<div class="mb-3">
									<div class="mb-2 w-100">
										<label class="text-muted" for="password">Senha</label>
										<a href="#" class="float-end">
											Esqueceu a senha?
										</a>
									</div>
									<input id="password" type="password" class="form-control" name="senha" required>
								    <div class="invalid-feedback">
								    	Senha é obrigatória
							    	</div>
								</div>

								<div class="d-flex align-items-center">
									<button type="submit" class="btn btn-primary w-100">
										Login
									</button>
								</div> 
							</form>
						</div>
						<div class="card-footer py-3 border-0">
							<div class="text-center">
								Não tem uma conta? <a href="telacadastro.php" class="text-dark">Crie uma</a>
							</div>
						</div>
					</div>
					<div class="text-center mt-5 text-muted">
						Copyright &copy; <?php echo date("Y"); ?> &mdash; Seu Sistema
					</div>
				</div>
			</div>
		</div>
	</section>
</body>
</html>