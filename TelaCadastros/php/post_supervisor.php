<?php

include_once('../../db/connect.php');
include_once('../../db/gdb_mysql.php');

$gdb = new gdb();

if ($conn->connect_error) {
    echo "<script>alert('Conexao falhou: " . $conn->connect_error . "'); window.location.href = 'https://pgs.pmf.sc.gov.br/TelaCadastros/#';</script>";
    exit;
}

if (empty($_POST['nomeSupervisor']) || empty($_POST['emailSupervisor']) || empty($_POST['matriculaSupervisor']) || empty($_POST['secretariaSupervisor'])) {
    echo "<script>alert('Todos os campos são obrigatórios e devem ser preenchidos.'); window.location.href = 'https://pgs.pmf.sc.gov.br/TelaCadastros/#';</script>";
    exit;
}

$nome = $_POST['nomeSupervisor'];
$email = $_POST['emailSupervisor'];
$matricula = $_POST['matriculaSupervisor'];
$secretaria = $_POST['secretariaSupervisor'];
$telefone = $_POST['telefoneSupervisor'];

if (!isset($_SESSION)) {
    session_start();
}

$idUsuario = $_SESSION["idUsuario"];
date_default_timezone_set('America/Sao_Paulo');
$current_time = date('d-m-Y H:i:s');

try {
    $gdb->open("START TRANSACTION");

    $gdb->open("SELECT idSecretaria 
                FROM secretarias 
                WHERE upper(siglaSecretaria) = upper('$secretaria') 
                   OR upper(nomeSecretaria) = upper('$secretaria')");
    if ($gdb->linhas == 0) {
        throw new Exception("Secretaria não encontrada.");
    }
    $idSecretaria = $gdb->gs['IDSECRETARIA'][0];

    $sql = "INSERT INTO supervisores (nomeSupervisor, emailSupervisor, matriculaSupervisor, telefoneSupervisor, idSecretaria) 
            VALUES ('$nome', '$email', '$matricula', '$telefone', '$idSecretaria')";
    $cadastroSupervisor = $gdb->open($sql);
    if (!$cadastroSupervisor) {
        throw new Exception("Erro ao adicionar registro: " . $conn->error);
    }

    $auditoriaSql = "INSERT INTO auditoria (tipoInteracao, idUsuario, horaAuditoria, nomeDoAlvo)
                     VALUES ('Cadastrou o(a) Supervisor(a)', '$idUsuario', '$current_time', '$nome')";
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
