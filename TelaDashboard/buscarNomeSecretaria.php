<?php
include_once('../db/gdb_mysql.php');

$gdb = new gdb();
$idSecretaria = intval($_POST['idSecretaria']);

$gdb->open('SELECT 
    nomeSecretaria AS NOMESECRETARIA
FROM 
    secretarias
WHERE 
    idSecretaria = ' . $idSecretaria);

$result = $gdb->gs;
echo json_encode($result);
?>
