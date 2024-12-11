<?php
include '../db/connect.php';
include_once('../db/gdb_mysql.php');
$gdb = new gdb();


// Verifica se o ID do contrato foi passado via POST
if (isset($_POST['idContrato'])) {
    $idContrato = intval($_POST['idContrato']);

    // Prepara e executa a atualização
    $stmt = $conn->prepare("UPDATE contratos SET arquivado = 1 WHERE idContrato = ?");
    $stmt->bind_param("i", $idContrato);


    header('Content-Type: application/json');
    if ($stmt->execute()) {
        http_response_code(200); // OK
        echo json_encode(['status' => 'success', 'message' => 'Contrato arquivado com sucesso.']);
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(['status' => 'error', 'message' => 'Erro ao arquivar contrato.']);
    }

    $stmt->close();
    $conn->close();
} else {
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
                           VALUES ('Arquivou o Contrato',
                                   '$idUsuario',
                                   '$current_time',
                                   '$nomeUsual')");


?>