<?php
require 'config.php';
$editando = false;
$registro = ['id_eleitor' => '', 'nome_completo' => '', 'cpf' => '', 'titulo_eleitor' => '', 'data_nascimento' => '', 'zona_eleitoral' => '', 'secao_eleitoral' => '', 'endereco' => '', 'cidade' => '', 'estado' => '', 'email' => '', 'telefone' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [$_POST['nome_completo'], preg_replace('/\\D/', '', $_POST['cpf']), $_POST['titulo_eleitor'], $_POST['data_nascimento'], $_POST['zona_eleitoral'] ?: null, $_POST['secao_eleitoral'] ?: null, $_POST['endereco'] ?: null, $_POST['cidade'] ?: null, strtoupper($_POST['estado']) ?: null, $_POST['email'] ?: null, $_POST['telefone'] ?: null];
    if (!empty($_POST['id_eleitor'])) {
        $sql = 'UPDATE eleitor1 SET nome_completo=?, cpf=?, titulo_eleitor=?, data_nascimento=?, zona_eleitoral=?, secao_eleitoral=?, endereco=?, cidade=?, estado=?, email=?, telefone=? WHERE id_eleitor=?';
        $dados[] = (int)$_POST['id_eleitor'];
    } else {
        $sql = 'INSERT INTO eleitor1 (nome_completo,cpf,titulo_eleitor,data_nascimento,zona_eleitoral,secao_eleitoral,endereco,cidade,estado,email,telefone) VALUES (?,?,?,?,?,?,?,?,?,?,?)';
    }
    try {
        $pdo->prepare($sql)->execute($dados);
        header('Location: eleitores.php?ok=1');
        exit;
    } catch (PDOException $e) {
        $erro = 'Não foi possível salvar. Verifique se CPF, título ou e-mail já estão cadastrados.';
    }
}
if (isset($_GET['excluir'])) {
    $pdo->prepare('DELETE FROM eleitor1 WHERE id_eleitor=?')->execute([(int)$_GET['excluir']]);
    header('Location: eleitores.php?ok=2');
    exit;
}
if (isset($_GET['editar'])) {
    $busca = $pdo->prepare('SELECT * FROM eleitor1 WHERE id_eleitor=?');
    $busca->execute([(int)$_GET['editar']]);
    $registro = $busca->fetch() ?: $registro;
    $editando = true;
}
$lista = $pdo->query('SELECT * FROM eleitor1 ORDER BY id_eleitor DESC')->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eleitores</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <h1>Gerenciamento de eleitores</h1>
        <p><a href="index.php">← Início</a></p>
    </header>
    <main class="container">
        <?php if (!empty($erro)): ?><div class="alert erro"><?= htmlspecialchars($erro) ?></div><?php endif; ?><?php if (isset($_GET['ok'])): ?><div class="alert sucesso">Operação realizada com sucesso.</div><?php endif; ?>
        <section class="form-box">
            <h2><?= $editando ? 'Editar eleitor' : 'Cadastrar eleitor' ?></h2>
            <form method="post"><input type="hidden" name="id_eleitor" value="<?= htmlspecialchars($registro['id_eleitor']) ?>">
                <div class="grid">
                    <label>Nome completo*<input required name="nome_completo" value="<?= htmlspecialchars($registro['nome_completo']) ?>"></label><label>CPF*<input required name="cpf" maxlength="14" value="<?= htmlspecialchars($registro['cpf']) ?>"></label><label>Título de eleitor*<input required name="titulo_eleitor" value="<?= htmlspecialchars($registro['titulo_eleitor']) ?>"></label><label>Data de nascimento*<input required type="date" name="data_nascimento" value="<?= htmlspecialchars($registro['data_nascimento']) ?>"></label><label>Zona eleitoral<input type="number" name="zona_eleitoral" value="<?= htmlspecialchars($registro['zona_eleitoral']) ?>"></label><label>Seção eleitoral<input type="number" name="secao_eleitoral" value="<?= htmlspecialchars($registro['secao_eleitoral']) ?>"></label><label>Endereço<input name="endereco" value="<?= htmlspecialchars($registro['endereco']) ?>"></label><label>Cidade<input name="cidade" value="<?= htmlspecialchars($registro['cidade']) ?>"></label><label>Estado<input maxlength="2" name="estado" value="<?= htmlspecialchars($registro['estado']) ?>"></label><label>E-mail<input type="email" name="email" value="<?= htmlspecialchars($registro['email']) ?>"></label><label>Telefone<input name="telefone" value="<?= htmlspecialchars($registro['telefone']) ?>"></label>
                </div><button type="submit"><?= $editando ? 'Atualizar' : 'Cadastrar' ?></button><?php if ($editando): ?><a class="cancelar" href="eleitores.php">Cancelar</a><?php endif; ?>
            </form>
        </section>
        <section>
            <h2>Eleitores cadastrados</h2>
            <div class="table-wrap">
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Título</th>
                        <th>Cidade/UF</th>
                        <th>Ações</th>
                    </tr><?php foreach ($lista as $item): ?><tr>
                            <td><?= $item['id_eleitor'] ?></td>
                            <td><?= htmlspecialchars($item['nome_completo']) ?></td>
                            <td><?= htmlspecialchars($item['cpf']) ?></td>
                            <td><?= htmlspecialchars($item['titulo_eleitor']) ?></td>
                            <td><?= htmlspecialchars($item['cidade'] . '/' . $item['estado']) ?></td>
                            <td><a class="acao editar" href="?editar=<?= $item['id_eleitor'] ?>">Editar</a> <a class="acao excluir" href="?excluir=<?= $item['id_eleitor'] ?>" onclick="return confirm('Excluir este eleitor?')">Excluir</a></td>
                        </tr><?php endforeach; ?>
                </table>
            </div>
        </section>
    </main>
</body>

</html>