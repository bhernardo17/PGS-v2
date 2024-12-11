<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
include '../db/connect.php';
include_once('../db/gdb_mysql.php');

$gdb = new gdb();


if (isset($_POST['nome']) || isset($_POST['matricula']) || isset($_POST['telefone']) || isset($_POST['e-mail']) || isset($_POST['nomeSecretaria']) || isset($_POST['permissao']) || isset($_POST['senha']) || isset($_POST['senhaRepetida'])) {

    $senha = $_POST['senha'];
    $senhaRepetida = $_POST['senhaRepetida'];
    $nome = $_POST['nome'];
    $matricula = $_POST['matricula'];
    $email = $_POST['e-mail'];
    $telefone = $_POST['telefone'];
    $secretariaNT = $_POST['nomeSecretaria'];
    $permissao = $_POST['permissao'];

    $gdb->open("SELECT idSecretaria 
                FROM secretarias 
                where upper(nomeSecretaria) = upper('$secretariaNT') OR upper(siglaSecretaria) = upper('$secretariaNT')", 1);
    $idSecretaria = $gdb->gs['IDSECRETARIA'][0]; 

    if ($senha === $senhaRepetida) {
        $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);


        $gdb->open("INSERT INTO usuario (nomeUsuario, 
                                        idSecretaria,
                                        matriculaUsuario, 
                                        senhaUsuario, 
                                        acessoUsuario, 
                                        permissaoUsuario, 
                                        emailUsuario, 
                                        telefone) 
                                VALUES  ('$nome',
                                         '$idSecretaria',
                                        '$matricula',
                                        '$senhaCriptografada',
                                        '$matricula',
                                        '$permissao',
                                        '$email',
                                        '$telefone')
        ", 1);



    }else {
        echo "Senhas Diferentes";

    }

}

if(!isset($_SESSION)) {
    session_start();
}

$idUsuario = $_SESSION["idUsuario"];
date_default_timezone_set('America/Sao_Paulo');
$current_time = date('d-m-Y H:i:s');

$gdb->open("INSERT INTO auditoria (tipoInteracao,
                                idUsuario,
                                horaAuditoria,
                                nomeDoAlvo)
                        VALUES ('Criou Usuário',
                                '$idUsuario',
                                '$current_time',
                                '$nome')", 1);

echo "<script> window.location.href = 'https://pgs.pmf.sc.gov.br/PermissaoUsuario/#';</script>";

?>
