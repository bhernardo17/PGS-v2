<?php
include '../db/connect.php';
include_once('../db/gdb_mysql.php');

$gdb = new gdb();

// Verifica se o idContrato foi passado corretamente via POST
if (isset($_POST['idContrato'])) {
    $idContrato = intval($_POST['idContrato']);

    // Prepara a query de atualização
    $stmt = $conn->prepare("UPDATE contratos SET arquivado = 0 WHERE idContrato = ?");
    $stmt->bind_param('i', $idContrato);

    // Tenta executar a query e retornar uma resposta JSON
    header('Content-Type: application/json');
    if ($stmt->execute()) {
        http_response_code(200); // OK
        echo json_encode(['status' => 'success', 'message' => 'Contrato desarquivado com sucesso.']);
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(['status' => 'error', 'message' => 'Erro ao desarquivar contrato.']);
    }

    $stmt->close();
    $conn->close();
} else {
    // Responde com erro caso o idContrato não seja fornecido
    header('Content-Type: application/json');
    http_response_code(400); // Bad Request
    echo json_encode(['status' => 'error', 'message' => 'ID do contrato não fornecido.']);
}

if(!isset($_SESSION)) {
    session_start();
}


$gdb->open("SELECT nomeUsual FROM contratos Where idContrato = $idContrato");
$nomeUsual = $gdb->gs['NOMEUSUAL'][0];

$idUsuario = $_SESSION["idUsuario"];
date_default_timezone_set('America/Sao_Paulo');
$current_time = date('d-m-Y H:i:s');

$gdb->open("INSERT INTO auditoria (tipoInteracao,
                                idUsuario,
                                horaAuditoria,
                                nomeDoAlvo)
                        VALUES ('Desarquivou o Contrato',
                                '$idUsuario',
                                '$current_time',
                                '$nomeUsual')");
?>