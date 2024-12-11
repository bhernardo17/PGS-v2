<?php

include '../../db/connect.php';
include_once('../../db/gdb_mysql.php');

$gdb = new gdb();

if ($conn->connect_error) {
    die("Conexao falhou: " . $conn->connect_error);
}

// Verifica se os campos estão definidos e não são vazios
if (empty($_POST['nomeFornecedor']) || empty($_POST['razaoFornecedor']) || empty($_POST['cnpjFornecedor'])) {
    echo "<script>alert('Todos os campos são obrigatórios e devem ser preenchidos.'); window.location.href = 'https://pgs.pmf.sc.gov.br/TelaCadastros/#';</script>";
    exit;
}

$nome = $_POST['nomeFornecedor'];
$razao = $_POST['razaoFornecedor'];
$cnpj = $_POST['cnpjFornecedor'];
$suporte = $_POST['suporteFornecedor'];
$email = $_POST['emailFornecedor'];

if (!isset($_SESSION)) {
    session_start();
}

$idUsuario = $_SESSION["idUsuario"];
date_default_timezone_set('America/Sao_Paulo');
$current_time = date('d-m-Y H:i:s');

try {
    $gdb->open("START TRANSACTION");

    $sql = "INSERT INTO fornecedor (nomeFornecedor, razaoFornecedor, cnpjFornecedor, suporteFornecedor, emailFornecedor) VALUES ('$nome', '$razao', '$cnpj', '$suporte', '$email')";
    $CadastroFornecedor = $gdb->open($sql);
    if (!$CadastroFornecedor) {
        throw new Exception("Erro ao adicionar registro: " . $conn->error);
    }

    $auditoriaSql = "INSERT INTO auditoria (tipoInteracao, idUsuario, horaAuditoria, nomeDoAlvo)
                     VALUES ('Cadastrou o Fornecedor', '$idUsuario', '$current_time', '$nome')";
    if (!$gdb->open($auditoriaSql)) {
        throw new Exception("Erro ao registrar auditoria");
    }

    $gdb->open("COMMIT");


    echo "<script>alert('Registro adicionado com sucesso!'); window.location.href = 'https://pgs.pmf.sc.gov.br/TelaCadastros/#';</script>";
} catch (Exception $e) {
    $gdb->open("ROLLBACK");
    echo "<script>alert('" . $e->getMessage() . "'); window.location.href = 'https://pgs.pmf.sc.gov.br/TelaCadastros/#';</script>";
} finally {
    $conn->close();
}


?>

