<?php
// Arquivo: conexao.php

// Usamos if (!defined()) para evitar o Warning de constante já definida.
if (!defined('HOST')) { 
    define('HOST', 'localhost');
    define('USUARIO', 'root');
    define('SENHA', '');
    define('DB', 'login');
}

// Estabelece a conexão e verifica erro de forma procedural
$conexao = mysqli_connect(HOST, USUARIO, SENHA, DB);

// Se a conexão falhar, interrompe o script
if (mysqli_connect_errno()) {
    die("Erro na conexão MySQL: " . mysqli_connect_error());
}

// Configura o charset
mysqli_set_charset($conexao, "utf8");
?>