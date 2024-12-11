<?php

include '../db/connect.php';
include_once('../db/gdb_mysql.php');

$gdb = new gdb();

if(!isset($_SESSION)) {
    session_start();
}

$idUsuario = $_SESSION["idUsuario"];
date_default_timezone_set('America/Sao_Paulo');
$current_time = date('d-m-Y H:i:s');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['nomeSupervisor']) && 
        isset($_POST['email']) &&
        isset($_POST['matricula']) &&
        isset($_POST['telefone']) &&
        isset($_POST['secretariaSupervisor'])) {

        $nomeSupervisor = $_POST['nomeSupervisor'];
        $emailSupervisor = $_POST['email'];
        $matricula = $_POST['matricula'];
        $telefone = $_POST['telefone'];
        $secretariaSupervisor = $_POST['secretariaSupervisor'];
        $idSupervisor = $_POST['idSupervisor'];

        $gdb->open("SELECT nomeSupervisor FROM supervisores WHERE idSupervisor = $idSupervisor");
        $nomeSupervisorAuditoria = $gdb->gs['NOMESUPERVISOR'][0];

        $gdb->open("SELECT idSecretaria 
                    FROM secretarias
                    WHERE upper(nomeSecretaria) = upper('$secretariaSupervisor')", 1);
        $idSecretaria = $gdb->gs['IDSECRETARIA'][0];

        $gdb->open("UPDATE supervisores 
                    SET nomeSupervisor = '$nomeSupervisor', 
                        emailSupervisor = '$emailSupervisor', 
                        matriculaSupervisor = '$matricula', 
                        telefoneSupervisor = '$telefone', 
                        idSecretaria = '$idSecretaria' 
                    WHERE idSupervisor = $idSupervisor", 1);

        $gdb->open("INSERT INTO auditoria (tipoInteracao,
                                        idUsuario,
                                        horaAuditoria,
                                        nomeDoAlvo)
                                VALUES ('Editou o Supervisor',
                                        '$idUsuario',
                                        '$current_time',
                                        '$nomeSupervisorAuditoria')", 1);

    
    } 
    else if(isset($_POST['nomeFornecedor']) &&
            isset($_POST['razao']) &&
            isset($_POST['cnpj'])){
            
            $nomeFornecedor = $_POST['nomeFornecedor'];
            $razao = $_POST['razao'];
            $cnpj = $_POST['cnpj'];
            $idFornecedor = $_POST['idFornecedor'];
            $suporteFornecedor = $_POST['suporteFornecedor'];
            $emailFornecedor = $_POST['emailFornecedor'];

            $gdb->open("SELECT nomeFornecedor FROM fornecedor WHERE idFornecedor = $idFornecedor");
            $nomeFornecedorAuditoria = $gdb->gs['NOMEFORNECEDOR'][0];
    

            $gdb->open("UPDATE fornecedor 
                    SET nomeFornecedor = '$nomeFornecedor', 
                        razaoFornecedor = '$razao', 
                        cnpjFornecedor = '$cnpj',
                        suporteFornecedor = '$suporteFornecedor',
                        emailFornecedor = '$emailFornecedor'
                    WHERE idFornecedor = '$idFornecedor'", 1);

            $gdb->open("INSERT INTO auditoria (tipoInteracao,
                                        idUsuario,
                                        horaAuditoria,
                                        nomeDoAlvo)
                                VALUES ('Editou o Fornecedor',
                                        '$idUsuario',
                                        '$current_time',
                                        '$nomeFornecedorAuditoria')", 1);
                     
    }
    else if(isset($_POST['nomeSecretaria']) &&
            isset($_POST['sigla']) &&
            isset($_POST['endereco']) &&
            isset($_POST['telefone']) &&
            isset($_POST['idSecretaria'])){

            $nomeSecretaria = $_POST['nomeSecretaria'];
            $sigla = $_POST['sigla'];
            $endereco = $_POST['endereco'];
            $telefone = $_POST['telefone'];
            $idSecretaria = $_POST['idSecretaria'];

            $gdb->open("SELECT nomeSecretaria FROM secretarias WHERE idSecretaria = $idSecretaria");
            $nomeSecretariaAuditoria = $gdb->gs['NOMESECRETARIA'][0];



            $gdb->open("UPDATE secretarias 
            SET nomeSecretaria = '$nomeSecretaria', 
                siglaSecretaria = '$sigla', 
                enderecoSecretaria = '$endereco',
                telefoneSecretaria = '$telefone'
            WHERE idSecretaria = '$idSecretaria'");

            $gdb->open("INSERT INTO auditoria (tipoInteracao,
                                        idUsuario,
                                        horaAuditoria,
                                        nomeDoAlvo)
                                VALUES ('Editou a Secretaria',
                                        '$idUsuario',
                                        '$current_time',
                                        '$nomeSecretariaAuditoria')", 1);


    };
}



echo "<script>window.location.href = 'http://pgs.pmf.sc.gov.br/TelaCadastros/#';</script>";
?>
