# Resumo da Atividade SAEP — CRUD Eleitoral

## 1. Apresentação

O projeto consiste em uma aplicação web desenvolvida em PHP integrada ao MySQL. A solução foi criada para demonstrar as operações básicas de um sistema CRUD: cadastrar, consultar, atualizar e excluir registros.

O banco de dados utilizado é denominado `eleitor` e possui as tabelas `eleitor` e `candidato`, conforme solicitado na atividade. A aplicação utiliza PDO e consultas preparadas para realizar a comunicação com o banco de dados.

## 2. Funcionalidades

A página inicial apresenta a quantidade de eleitores e candidatos cadastrados. No módulo de eleitores é possível cadastrar nome, CPF, título de eleitor, data de nascimento, zona, seção, endereço, cidade, estado, e-mail e telefone. No módulo de candidatos é possível cadastrar nome, número, partido, cargo, data de nascimento, e-mail e telefone.

Os registros são exibidos em tabelas e possuem botões para edição e exclusão. A exclusão possui uma confirmação no navegador para evitar remoções acidentais. O banco também possui restrições de unicidade para CPF, título de eleitor, e-mail e número do candidato.

## 3. Arquivos principais

| Arquivo | Função |
|---|---|
| `eleitor.sql` | Cria o banco, as tabelas e dados de exemplo. |
| `config.php` | Configura e abre a conexão PDO com o MySQL. |
| `index.php` | Página inicial com resumo dos registros. |
| `eleitores.php` | CRUD completo de eleitores. |
| `candidatos.php` | CRUD completo de candidatos. |
| `style.css` | Estilos visuais e adaptação para telas menores. |

## 4. Instalação

1. Instale o XAMPP, WAMP ou outro servidor com Apache, PHP e MySQL.
2. Copie esta pasta para o diretório público do servidor, por exemplo `htdocs/Atividade_SAEP_site` no XAMPP.
3. Abra o MySQL pelo phpMyAdmin ou MySQL Workbench.
4. Importe o arquivo `eleitor.sql` e execute o script completo.
5. Confira o arquivo `config.php`. A configuração padrão utiliza usuário `root`, senha vazia e servidor `localhost`.
6. Inicie Apache e MySQL.
7. Acesse `http://localhost/Atividade_SAEP_site/` no navegador.

Se o MySQL tiver uma senha configurada para o usuário `root`, altere a variável `$pass` no arquivo `config.php`.

## 5. Demonstração para os prints

Para comprovar o funcionamento na documentação, recomenda-se registrar prints da página inicial, do formulário de cadastro, da listagem após o cadastro, da tela de edição com dados alterados e da confirmação de exclusão. Faça isso para pelo menos um eleitor e um candidato.

## 6. Participação no SCRUM

A divisão dos papéis pode ser preenchida pelo grupo na documentação final. Um exemplo é: Product Owner responsável por levantar os requisitos; Scrum Master responsável por organizar as reuniões e acompanhar o andamento; e equipe de desenvolvimento responsável pelo banco de dados, programação PHP, testes e documentação.

## 7. Observação

Os dados presentes no arquivo SQL são fictícios e devem ser substituídos ou complementados pelos dados definidos pelo grupo. O arquivo de entrega individual deve seguir o padrão solicitado pela atividade: `Nome_Sobrenome_Atividade_SAEP.pdf`.
