<?php
include '../db/connect.php';
include_once('../db/gdb_mysql.php');

header('Content-Type: application/json');

$gdb = new gdb();
$response = [];

try {
    if (isset($_POST['idUsuario'])) {
        $idUsuario = intval($_POST['idUsuario']);

        $gdb->open("SELECT nomeUsuario FROM usuario WHERE idUsuario = $idUsuario");
        $nomeUsuario = $gdb->gs['NOMEUSUARIO'][0];

        $gdb->open("DELETE FROM usuario WHERE idUsuario = $idUsuario");

        if (!isset($_SESSION)) {
            session_start();
        }

        $idUsuario2 = $_SESSION["idUsuario"];
        date_default_timezone_set('America/Sao_Paulo');
        $current_time = date('d-m-Y H:i:s');

        $gdb->open("INSERT INTO auditoria (tipoInteracao, idUsuario, horaAuditoria, nomeDoAlvo) VALUES ('Deletou o Usuário', '$idUsuario2', '$current_time', '$nomeUsuario')");

        $response = [
            'status' => 'success',
            'message' => 'Usuário deletado com sucesso.'
        ];
    } else {
        $response = [
            'status' => 'error',
            'message' => 'ID do usuário não fornecido.'
    ];
    }
} catch (Exception $e) {
    $response = [
        'status' => 'error',
        'message' => 'Erro ao deletar usuário: ' . $e->getMessage()
    ];
}

echo json_encode($response);
exit();
?>
