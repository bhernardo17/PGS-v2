<?php
include '../db/connect.php';
include_once('../db/gdb_mysql.php');

header('Content-Type: application/json');

$gdb = new gdb();
$response = [];

function generateResetCode($length = 6) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}

try {
    if (isset($_POST['idUsuario'])) {
        $idUsuario = intval($_POST['idUsuario']);

        $gdb->open("SELECT nomeUsuario FROM usuario WHERE idUsuario = $idUsuario");
        $nomeUsuario = $gdb->gs['NOMEUSUARIO'][0];
        $codeReset = generateResetCode();

        $gdb->open("UPDATE usuario 
                    SET    resetSenha = 1,
                           codeReset = '$codeReset'
                    WHERE  idUsuario = $idUsuario");

        if (!isset($_SESSION)) {
            session_start();
        }

        $idUsuario2 = $_SESSION["idUsuario"];
        date_default_timezone_set('America/Sao_Paulo');
        $current_time = date('d-m-Y H:i:s');

        $gdb->open("INSERT INTO auditoria (tipoInteracao, idUsuario, horaAuditoria, nomeDoAlvo) VALUES ('Resetou a Senha do Usuário', '$idUsuario2', '$current_time', '$nomeUsuario')");

        $response = [
            'status' => 'success',
            'message' => 'Código de Reset: ' . $codeReset
        ];
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Usuário não fornecido.'
    ];
    }
} catch (Exception $e) {
    $response = [
        'status' => 'error',
        'message' => 'Erro ao Resetar Senha: ' . $e->getMessage()
    ];
}

echo json_encode($response);
exit();
?>