<?php
header('Content-Type: application/json; charset=utf-8');
require 'config.php';

$tipo = $_GET['tipo'] ?? '';
$metodo = $_SERVER['REQUEST_METHOD'];
$entrada = json_decode(file_get_contents('php://input'), true) ?: $_POST;

try {
    if (!in_array($tipo, ['eleitores', 'candidatos'], true)) {
        http_response_code(400);
        echo json_encode(['erro' => 'Tipo de registro inválido.']);
        exit;
    }

    if ($tipo === 'eleitores') {
        $tabela = 'eleitor1';
        if ($metodo === 'GET') {
            $lista = $pdo->query('SELECT id_eleitor AS id, nome_completo AS nome, cpf, titulo_eleitor AS titulo, data_nascimento AS data, zona_eleitoral AS zona, secao_eleitoral AS secao, endereco, cidade, estado, email, telefone FROM eleitor1 ORDER BY id_eleitor DESC')->fetchAll();
            echo json_encode($lista, JSON_UNESCAPED_UNICODE); exit;
        }
        $dados = [$entrada['nome'], preg_replace('/\D/', '', $entrada['cpf'] ?? ''), $entrada['titulo'], $entrada['data'], $entrada['zona'] ?: null, $entrada['secao'] ?: null, $entrada['endereco'] ?: null, $entrada['cidade'] ?: null, strtoupper($entrada['estado'] ?? '') ?: null, $entrada['email'] ?: null, $entrada['telefone'] ?: null];
        if ($metodo === 'POST') {
            $pdo->prepare('INSERT INTO eleitor1 (nome_completo,cpf,titulo_eleitor,data_nascimento,zona_eleitoral,secao_eleitoral,endereco,cidade,estado,email,telefone) VALUES (?,?,?,?,?,?,?,?,?,?,?)')->execute($dados);
        } elseif ($metodo === 'PUT') {
            $dados[] = (int)$entrada['id'];
            $pdo->prepare('UPDATE eleitor1 SET nome_completo=?,cpf=?,titulo_eleitor=?,data_nascimento=?,zona_eleitoral=?,secao_eleitoral=?,endereco=?,cidade=?,estado=?,email=?,telefone=? WHERE id_eleitor=?')->execute($dados);
        } elseif ($metodo === 'DELETE') {
            $pdo->prepare('DELETE FROM eleitor1 WHERE id_eleitor=?')->execute([(int)($entrada['id'] ?? $_GET['id'])]);
        }
    } else {
        if ($metodo === 'GET') {
            $lista = $pdo->query('SELECT id_candidato AS id, nome_completo AS nome, numero, partido, cargo, data_nascimento AS data, email, telefone FROM candidato1 ORDER BY id_candidato DESC')->fetchAll();
            echo json_encode($lista, JSON_UNESCAPED_UNICODE); exit;
        }
        $dados = [$entrada['nome'], (int)$entrada['numero'], $entrada['partido'], $entrada['cargo'], $entrada['data'] ?: null, $entrada['email'] ?: null, $entrada['telefone'] ?: null];
        if ($metodo === 'POST') {
            $pdo->prepare('INSERT INTO candidato1 (nome_completo,numero,partido,cargo,data_nascimento,email,telefone) VALUES (?,?,?,?,?,?,?)')->execute($dados);
        } elseif ($metodo === 'PUT') {
            $dados[] = (int)$entrada['id'];
            $pdo->prepare('UPDATE candidato1 SET nome_completo=?,numero=?,partido=?,cargo=?,data_nascimento=?,email=?,telefone=? WHERE id_candidato=?')->execute($dados);
        } elseif ($metodo === 'DELETE') {
            $pdo->prepare('DELETE FROM candidato1 WHERE id_candidato=?')->execute([(int)($entrada['id'] ?? $_GET['id'])]);
        }
    }
    echo json_encode(['sucesso' => true], JSON_UNESCAPED_UNICODE);
} catch (PDOException $e) {
    http_response_code(422);
    if ($metodo === 'GET') {
        // Erro ao consultar/carregar dados: mostra a causa real (tabela ausente, coluna errada, etc.)
        echo json_encode(['erro' => 'Não foi possível carregar os dados. Detalhe: ' . $e->getMessage()], JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode(['erro' => 'Não foi possível concluir a operação. Verifique se não há CPF, título, e-mail ou número duplicado. Detalhe: ' . $e->getMessage()], JSON_UNESCAPED_UNICODE);
    }
}
?>
