<?php require 'config.php';
$totalEleitores = $pdo->query('SELECT COUNT(*) FROM eleitor1')->fetchColumn();
$totalCandidatos = $pdo->query('SELECT COUNT(*) FROM candidato1')->fetchColumn();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Eleitoral</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <h1>CRUD Eleitoral</h1>
        <p>Atividade SAEP — PHP e MySQL</p>
    </header>
    <main class="container">
        <section class="cards">
            <div class="card"><strong><?= $totalEleitores ?></strong><span>Eleitores cadastrados</span></div>
            <div class="card"><strong><?= $totalCandidatos ?></strong><span>Candidatos cadastrados</span></div>
        </section>
        <section class="menu"><a href="eleitores.php">Gerenciar eleitores</a><a href="candidatos.php">Gerenciar candidatos</a></section>
        <section class="info">
            <h2>Sobre o sistema</h2>
            <p>Este sistema permite cadastrar, consultar, atualizar e excluir registros de eleitores e candidatos.</p>
        </section>
    </main>
    <footer>Atividade SAEP — CRUD com PHP e MySQL</footer>
</body>

</html>