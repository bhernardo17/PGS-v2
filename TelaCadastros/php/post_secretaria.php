<?php
ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);
include_once('../../db/connect.php');
include_once('../../db/gdb_mysql.php');

$gdb = new gdb();

if ($conn->connect_error) {
    echo "<script>alert('Conexao falhou: " . $conn->connect_error . "'); window.location.href = 'https://pgs.pmf.sc.gov.br/TelaCadastros/#';</script>";
    exit;
}

if (empty($_POST['nomeSecretaria']) || empty($_POST['siglaSecretaria']) || empty($_POST['enderecoSecretaria'])) {
    echo "<script>alert('Todos os campos são obrigatórios e devem ser preenchidos.'); window.location.href = 'https://pgs.pmf.sc.gov.br/TelaCadastros/#';</script>";
    exit;
}

$nome = $_POST['nomeSecretaria'];
$sigla = $_POST['siglaSecretaria'];
$endereco = $_POST['enderecoSecretaria'];
$telefone = $_POST['telefone_sec'];

if (!isset($_SESSION)) {
    session_start();
}

$idUsuario = $_SESSION["idUsuario"];
date_default_timezone_set('America/Sao_Paulo');
$current_time = date('d-m-Y H:i:s');

try {
    $gdb->open("START TRANSACTION");

    $sql = "INSERT INTO secretarias (nomeSecretaria, siglaSecretaria, enderecoSecretaria, telefoneSecretaria) VALUES ('$nome', '$sigla', '$endereco', '$telefone')";
    $cadastroSecretaria = $gdb->open($sql);
    if (!$cadastroSecretaria) {
        throw new Exception("Erro ao adicionar registro: " . $conn->error);
    }

    $auditoriaSql = "INSERT INTO auditoria (tipoInteracao, idUsuario, horaAuditoria, nomeDoAlvo)
                     VALUES ('Cadastrou a Secretaria/Autarquia', '$idUsuario', '$current_time', '$nome')";
    
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