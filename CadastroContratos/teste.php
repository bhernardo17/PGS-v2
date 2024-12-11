<?php
  ini_set('display_errors',1);
  ini_set('display_startup_erros',1);
  error_reporting(E_ALL);
// Inclui o arquivo de conexão com o banco de dados
include '../db/connect.php';
include_once('../db/gdb_mysql.php');
if(!isset($_SESSION)) {
    session_start();
}
$gdb = new gdb();

$nomesupervisores = $_POST['supResponsavel'];
$tiposupervisores = $_POST['supStatus'];

try {

    if (isset($_POST['supResponsavel']) && isset($_POST['supStatus'])) {
        for ($i = 0; $i < count($nomesupervisores); $i++) {
            $nomesupervisor = $conn->real_escape_string($nomesupervisores[$i]);
            $tiposupervisor = $conn->real_escape_string($tiposupervisores[$i]);
        
            // pega ID supervisor
            $gdb->open("SELECT idSupervisor 
                        FROM supervisores 
                        WHERE upper(nomeSupervisor) = upper('$nomesupervisor')");
            $idSupervisor = $gdb->gs['IDSUPERVISOR'][0];
            // echo "<script>alert('Id Supervisor $idSupervisor');</script>";

            // pega ID do contrato mais recente
            $gdb->open("SELECT idContrato FROM contratos ORDER BY idContrato DESC LIMIT 1");
            $idContrato = $gdb->gs['IDCONTRATO'][0];
            // echo "<script>alert('idContrato antigo: $idContrato');</script>";
            $novoidContrato = $idContrato +1;
            // echo "<script>alert('idContrato novo: $novoidContrato');</script>";

            // cadastro no banco
            $supervisoresSQL = "INSERT INTO contratoXsupervisor (idContrato, idSupervisor, tipoSupervisor) 
                            VALUES ('$novoidContrato', '$idSupervisor', '$tiposupervisor')";
            $CADsuper = $gdb->open($supervisoresSQL);
            
            
            if (!$CADsuper) {
                throw new Exception("Erro ao cadastrar supervisor $nomesupervisor");
            } else {
                echo "Supervisor $nomesupervisor cadastrado com sucesso.<br>";
            }
        }
    } else {
        throw new Exception("Dados não recebidos corretamente.");
    }
}
 catch (Exception $e) {
    // ROLLBACK cancela todos os SQL feitos a te agora, oq so acontece caso tenha uma Exception, dada pelo Throw Exception
    $gdb->open("ROLLBACK");
    echo "<script>alert('" . $e->getMessage() . "');</script>";
}
?>
