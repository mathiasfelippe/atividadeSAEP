<?php
// Configuração para conectar o PHP ao banco criado no MySQL Workbench.
$host = 'localhost';
$banco = 'eleitor';
$usuario = 'root';
$senha = 'Senai@118';

try {
    $pdo = new PDO(
        "mysql:host={$host};dbname={$banco};charset=utf8mb4",
        $usuario,
        $senha,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch (PDOException $erro) {
    die('Erro na conexão com o MySQL: ' . $erro->getMessage());
}
?>
