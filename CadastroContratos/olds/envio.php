<?php
include '../db/connect.php';
include_once('../db/gdb_mysql.php');
if(!isset($_SESSION)) {
    session_start();
}


$gdb = new gdb();


// Receber dados via POST com sanitização
$nomeComercial = $_POST['nomeComercial'];
$vigenciaInicial = $_POST['vigenciaInicial'];
$vigenciaFinal = $_POST['vigenciaFinal'];
$infoContratuais = $_POST['infoContratuais'];
$classContrato = $_POST['classContrato'];
$nomeUsual = $_POST['nomeUsual'];
$objetoContrato = $_POST['objetoContrato'];
$observacaoContrato = $_POST['observacaoContrato'];
$fornecedor = $_POST['fornecedor'];


//Tratamento do Custo
$custoAnual = $_POST['custoAnual'];
$custoAnualFloat = floatval(str_replace(',', '.', $custoAnual));
$custoMensal = $_POST['custoMensal'];
$custoMensalFloat = floatval(str_replace(',', '.', $custoMensal));


// //Tratamento de string para arrays
$secretaria = $_POST['secretaria'];
$arraySecretarias = array_map('trim', explode(',', $secretaria));

$superEgov = $_POST['superEgov'];
$arraySuperEgov = array_map('trim', explode(',', $superEgov));

$superFiscal = $_POST['superFiscal'];
$arraySuperFiscal = array_map('trim', explode(',', $superFiscal));

$superGestor = $_POST['superGestor'];
$arraySuperGestor = array_map('trim', explode(',', $superGestor));
print'<pre>';
print_r($_POST);
print_r($custoMensal);
print'<\pre>';
print_r($arraySecretarias);
echo "\n";
print_r($arraySuperEgov);
echo "\n";
print_r($arraySuperFiscal);
echo "\n";
print_r($arraySuperGestor);

function inserirSupervisores($arraySupervisores, $tipo, $conn, $nomeComercial, $idContrato) {
    foreach ($arraySupervisores as $nomeSupervisor) {
        $matriculaSupervisor = intval($nomeSupervisor);
        $gdb = new gdb();
        $gdb->open("SELECT idSupervisor
                    FROM supervisores
                    WHERE upper(nomeSupervisor) = upper('$nomeSupervisor') OR matriculaSupervisor == intval($matriculaSupervisor) ", 1);
        if($gdb->linhas == 1 ){
            $idSupervisor = $gdb->gs['IDSUPERVISOR'][0];
            $sql3 = "INSERT INTO contratoXsupervisor (idSupervisor,
                                                      idContrato,
                                                      tipoSupervisor)
                                             VALUES ('$idSupervisor',  
                                                     '$idContrato',
                                                     '$tipo')";
            
            $gdb->open($sql3,1);
        }
    }
}


//Pegando id do fornecedor pelo nome
$gdb->open("SELECT idFornecedor
              FROM fornecedor
             WHERE upper(nomeFornecedor) = upper('$fornecedor') or upper(razaoFornecedor) = upper('$fornecedor')",1);

//Salvando dados do contrato no banco
if($gdb->linhas == 1 ){
        $idFornecedor = $gdb->gs['IDFORNECEDOR'][0];
        $sql = "INSERT INTO contratos (vigenciaInicial,
                                        vigenciaFinal,
                                       custoAnual,
                                       custoMensal,
                                       infoContratuais,
                                       observacaoContrato,
                                       objetoContrato,
                                       nomeUsual,
                                       nomeComercial,
                                       classificacaoContrato,
                                       idFornecedor)
                              VALUES ('$vigenciaInicial',
                                      '$vigenciaFinal',
                                      '$custoAnualFloat',
                                      '$custoMensalFloat',
                                      '$infoContratuais',
                                      '$observacaoContrato',
                                      '$objetoContrato',
                                      '$nomeUsual',
                                      '$nomeComercial',
                                      '$classContrato',
                                      '$idFornecedor')";
       $gdb->open($sql,1);    

}else {
    

}

//Pegando ID do ultimo contrato inserido
$gdb->open("SELECT idContrato
              FROM contratos
             WHERE upper(nomeComercial) = upper('$nomeComercial') ",1);
$idContrato = $gdb->gs['IDCONTRATO'][0];

//Enviando Documentos para o wincp e criando variaveis de nomes e path
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['documentos'])) {
    $uploadDirectory = "/var/www/sistemas/pgs/CadastroContratos/documentos/";

    foreach ($_FILES['documentos']['name'] as $key => $filename) {
        $fileTmpPath = $_FILES['documentos']['tmp_name'][$key];
        $fileId = bin2hex(random_bytes(16));
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $filePath = $uploadDirectory . $fileId . '.' . $extension;
        print_r("O FILEPATH É: $filePath");

        if ($_FILES['documentos']['error'][$key] == 0 && move_uploaded_file($fileTmpPath, $filePath)) {
            echo "Arquivo $filename enviado com sucesso!<br>";

            //Inserindo dados na tabela documento
            $caminhoArquivo = "/var/www/sistemas/pgs/CadastroContratos/documentos/" . $fileID;
            print_r($caminhoArquivo);
            $sql2 = "INSERT INTO documentos (idContrato,
                                            caminhoDocumento,
                                            nomeDocumento,
                                            nomeAntigo)
                                VALUES ('$idContrato',
                                        '$filePath',
                                        '$fileId',
                                        '$filename')";
        
            $gdb->open($sql2,1);
            
        }
    }
}

inserirSupervisores($arraySuperEgov, "Fiscal E-Gov", $conn, $nomeComercial, $idContrato);
inserirSupervisores($arraySuperFiscal, "Fiscal", $conn, $nomeComercial, $idContrato);
inserirSupervisores($arraySuperGestor, "Gestor", $conn, $nomeComercial, $idContrato);
    
foreach ($arraySecretarias as $nomeSecretaria) {
    $gdb->open("SELECT idSecretaria
                FROM secretarias
                WHERE upper(siglaSecretaria) = upper('$nomeSecretaria')
                   OR upper(nomeSecretaria) = upper('$nomeSecretaria')", 1);
                $idSecretaria = $gdb->gs['IDSECRETARIA'][0];
    if($gdb->linhas == 1){
        
        $sql4 = "INSERT INTO contratoXsecretaria (idSecretaria, idContrato) VALUES ('$idSecretaria', '$idContrato')";
        $gdb->open($sql4,1);
    }
}

$idUsuario = $_SESSION["idUsuario"];
date_default_timezone_set('America/Sao_Paulo');
$current_time = date('d-m-Y H:i:s');

$gdb->open("INSERT INTO auditoria (tipoInteracao,
                                   idUsuario,
                                   horaAuditoria,
                                   nomeDoAlvo)
                           VALUES ('Cadastrou o Contrato',
                                   '$idUsuario',
                                   '$current_time',
                                   '$nomeUsual')", 1);




// header('Location: http://192.168.12.4/desenvolvimento/desenv4/pgs_fim/CadastroContratos/');
?>