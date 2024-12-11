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
    if (isset($_POST['email'])) {
        $gmail = $_POST['email'];

        $gdb->open("SELECT idUsuario FROM usuario WHERE emailUsuario = $gmail");
        $idUsuario = $gdb->gs['IDUSUARIO'][0];
        $codeReset = generateResetCode();

        $gdb->open("UPDATE usuario 
                    SET    resetSenha = 1,
                           codeReset = '$codeReset'
                    WHERE  idUsuario = $idUsuario");


        date_default_timezone_set('America/Sao_Paulo');
        $current_time = date('d-m-Y H:i:s');

        $gdb->open("INSERT INTO auditoria (tipoInteracao, idUsuario, horaAuditoria, nomeDoAlvo) VALUES ('Resetou a Senha do Usuário', 'Sistema', '$current_time', '$nomeUsuario')");

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