<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
include_once('../db/connect.php');
include_once('../db/gdb_mysql.php');

if (!isset($_SESSION)) {
    session_start();
}

$gdb = new gdb();
$idContrato = intval($_POST['codigo']); // Sanitização básica, considere usar prepared statements.

$result = $gdb->open("SELECT nomeUsual FROM contratos WHERE idContrato = $idContrato");
$nomeContrato = $gdb->gs['nomeUsual'][0];
echo($nomeContrato);

try {
    $gdb->open("START TRANSACTION");

    $deleteDocumentos = $gdb->open("DELETE FROM documentos WHERE idContrato = $idContrato");
    if (!$deleteDocumentos) {
        throw new Exception("Erro ao Apagar a Tabela: Documentos $nomeContrato");
    }

    $deleteContratoXSecretaria = $gdb->open("DELETE FROM contratoXsecretaria WHERE idContrato = $idContrato");
    if (!$deleteContratoXSecretaria) {
        throw new Exception("Erro ao Apagar a Tabela: ContratoXSecretaria");
    }

    $deleteContratoXSupervisor = $gdb->open("DELETE FROM contratoXsupervisor WHERE idContrato = $idContrato");
    if (!$deleteContratoXSupervisor) {
        throw new Exception("Erro ao Apagar a Tabela: ContratoXSupervisor");
    }

    $deleteContratos = $gdb->open("DELETE FROM contratos WHERE idContrato = $idContrato");
    if (!$deleteContratos) {
        throw new Exception("Erro ao Apagar a Tabela: Contratos");
    }

    $gdb->open("COMMIT");

    $idUsuario = $_SESSION["idUsuario"];
    date_default_timezone_set('America/Sao_Paulo');
    $current_time = date('d-m-Y H:i:s');

    $gdb->open("INSERT INTO auditoria (tipoInteracao, idUsuario, horaAuditoria, nomeDoAlvo)
                VALUES ('Excluiu o Contrato', $idUsuario, '$current_time', '$nomeContrato')");

    echo "Contrato deletado com sucesso.";

} catch (Exception $e) {
    $gdb->open("ROLLBACK");
    echo "Erro: " . $e->getMessage();
}
?>
