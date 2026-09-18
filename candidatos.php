<?php
require 'config.php';
$editando = false;
$registro = ['id_candidato' => '', 'nome_completo' => '', 'numero' => '', 'partido' => '', 'cargo' => '', 'data_nascimento' => '', 'email' => '', 'telefone' => ''];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [$_POST['nome_completo'], (int)$_POST['numero'], $_POST['partido'], $_POST['cargo'], $_POST['data_nascimento'] ?: null, $_POST['email'] ?: null, $_POST['telefone'] ?: null];
    if (!empty($_POST['id_candidato'])) {
        $sql = 'UPDATE candidato1 SET nome_completo=?, numero=?, partido=?, cargo=?, data_nascimento=?, email=?, telefone=? WHERE id_candidato=?';
        $dados[] = (int)$_POST['id_candidato'];
    } else {
        $sql = 'INSERT INTO candidato1 (nome_completo,numero,partido,cargo,data_nascimento,email,telefone) VALUES (?,?,?,?,?,?,?)';
    }
    try {
        $pdo->prepare($sql)->execute($dados);
        header('Location: candidatos.php?ok=1');
        exit;
    } catch (PDOException $e) {
        $erro = 'Não foi possível salvar. Verifique se o número ou e-mail já estão cadastrados.';
    }
}
if (isset($_GET['excluir'])) {
    $pdo->prepare('DELETE FROM candidato1 WHERE id_candidato=?')->execute([(int)$_GET['excluir']]);
    header('Location: candidatos.php?ok=2');
    exit;
}
if (isset($_GET['editar'])) {
    $busca = $pdo->prepare('SELECT * FROM candidato1 WHERE id_candidato=?');
    $busca->execute([(int)$_GET['editar']]);
    $registro = $busca->fetch() ?: $registro;
    $editando = true;
}
$lista = $pdo->query('SELECT * FROM candidato1 ORDER BY id_candidato DESC')->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidatos</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <h1>Gerenciamento de candidatos</h1>
        <p><a href="index.php">← Início</a></p>
    </header>
    <main class="container">
        <?php if (!empty($erro)): ?><div class="alert erro"><?= htmlspecialchars($erro) ?></div><?php endif; ?><?php if (isset($_GET['ok'])): ?><div class="alert sucesso">Operação realizada com sucesso.</div><?php endif; ?><section class="form-box">
            <h2><?= $editando ? 'Editar candidato' : 'Cadastrar candidato' ?></h2>
            <form method="post"><input type="hidden" name="id_candidato" value="<?= htmlspecialchars($registro['id_candidato']) ?>">
                <div class="grid"><label>Nome completo*<input required name="nome_completo" value="<?= htmlspecialchars($registro['nome_completo']) ?>"></label><label>Número*<input required type="number" name="numero" value="<?= htmlspecialchars($registro['numero']) ?>"></label><label>Partido*<input required name="partido" value="<?= htmlspecialchars($registro['partido']) ?>"></label><label>Cargo*<input required name="cargo" value="<?= htmlspecialchars($registro['cargo']) ?>"></label><label>Data de nascimento<input type="date" name="data_nascimento" value="<?= htmlspecialchars($registro['data_nascimento']) ?>"></label><label>E-mail<input type="email" name="email" value="<?= htmlspecialchars($registro['email']) ?>"></label><label>Telefone<input name="telefone" value="<?= htmlspecialchars($registro['telefone']) ?>"></label></div><button type="submit"><?= $editando ? 'Atualizar' : 'Cadastrar' ?></button><?php if ($editando): ?><a class="cancelar" href="candidatos.php">Cancelar</a><?php endif; ?>
            </form>
        </section>
        <section>
            <h2>Candidatos cadastrados</h2>
            <div class="table-wrap">
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Número</th>
                        <th>Partido</th>
                        <th>Cargo</th>
                        <th>Ações</th>
                    </tr><?php foreach ($lista as $item): ?><tr>
                            <td><?= $item['id_candidato'] ?></td>
                            <td><?= htmlspecialchars($item['nome_completo']) ?></td>
                            <td><?= $item['numero'] ?></td>
                            <td><?= htmlspecialchars($item['partido']) ?></td>
                            <td><?= htmlspecialchars($item['cargo']) ?></td>
                            <td><a class="acao editar" href="?editar=<?= $item['id_candidato'] ?>">Editar</a> <a class="acao excluir" href="?excluir=<?= $item['id_candidato'] ?>" onclick="return confirm('Excluir este candidato?')">Excluir</a></td>
                        </tr><?php endforeach; ?>
                </table>
            </div>
        </section>
    </main>
</body>

</html>