<?php
include_once ('../db/connect.php');
include_once ('../db/gdb_mysql.php');
if(!isset($_SESSION)) {
       session_start();
}
   

$gdb = new gdb();



if (isset($_POST['nome']) || isset($_POST['matricula']) || isset($_POST['telefone']) || isset($_POST['e-mail']) || isset($_POST['nomeSecretaria']) || isset($_POST['permissao'])) {

    $nome = $_POST['nome'];
    $matricula = $_POST['matricula'];
    $email = $_POST['e-mail'];
    $telefone = $_POST['telefone'];
    $secretariaNT = $_POST['nomeSecretaria'];
    $permissao = $_POST['permissao'];
    $idUsuario = $_POST['idUsuario'];

    $gdb->open("SELECT idSecretaria 
    FROM secretarias 
    where upper(nomeSecretaria) = upper('$secretariaNT') OR upper(siglaSecretaria) = upper('$secretariaNT')", 1);
    $idSecretaria = $gdb->gs['IDSECRETARIA'][0];
    
    $gdb->open("UPDATE usuario
                SET    nomeUsuario = '$nome',
                       matriculaUsuario = '$matricula',
                       permissaoUsuario = '$permissao',
                       emailUsuario = '$email',
                       telefone = '$telefone',
                       idSecretaria = '$idSecretaria'
                WHERE  idUsuario = $idUsuario", 1);

}


$idUsuario = $_SESSION["idUsuario"];
date_default_timezone_set('America/Sao_Paulo');
$current_time = date('d-m-Y H:i:s');

$gdb->open("INSERT INTO auditoria (tipoInteracao,
                                   idUsuario,
                                   horaAuditoria,
                                   nomeDoAlvo)
                           VALUES ('Editou o Usuário',
                                   '$idUsuario',
                                   '$current_time',
                                   '$nome')", 1);

echo "<script> window.location.href = 'https://pgs.pmf.sc.gov.br/PermissaoUsuario/#';</script>";
?>

