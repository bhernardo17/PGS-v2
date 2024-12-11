<?php
include_once ('../db/connect.php');
include_once ('../db/gdb_mysql.php');

$gdb = new gdb();

$vigenciaInicial = $_POST['vigenciaInicial'];
$vigenciaFinal = $_POST['vigenciaFinal'];
$custoAnual = $_POST['custoAnual'];
$custoMensal = $_POST['custoMensal'];
$infoContratuais = $_POST['infoContratuais']; 
$observacao = $_POST['observacoesContrato'];
$objeto = $_POST['objetoContrato'];
$idContrato = $_POST['idContrato'];
$nomeComercial = $_POST['nomeComercial'];
$nomeUsual = $_POST['nomeUsual'];

$secretaria = $_POST['secretaria'];
$arraySecretarias = array_map('trim', explode(',', $secretaria));

$superEgov = $_POST['superEgov'];
$arraySuperEgov = array_map('trim', explode(',', $superEgov));

$superFiscal = $_POST['superFiscal'];
$arraySuperFiscal = array_map('trim', explode(',', $superFiscal));

$superGestor = $_POST['superGestor'];
$arraySuperGestor = array_map('trim', explode(',', $superGestor));


print_r($_POST);

$gdb->open("UPDATE contratos 
            SET     vigenciaInicial = '$vigenciaInicial',
                    vigenciaFinal = '$vigenciaFinal',
                    custoAnual = '$custoAnual',
                    custoMensal = '$custoMensal',
                    infoContratuais = '$infoContratuais',
                    observacaoContrato = '$observacao',
                    objetoContrato = '$objeto',
                    nomeComercial = '$nomeComercial',
                    nomeUsual = '$nomeUsual'
            WHERE   idContrato = $idContrato", 1);

editarSecretarias($arraySecretarias, $conn, $idContrato, $gdb);
editarSupervisores($arraySuperEgov, "Fiscal E-Gov", $conn, $idContrato, $gdb);
editarSupervisores($arraySuperFiscal, "Fiscal", $conn, $idContrato, $gdb);
editarSupervisores($arraySuperGestor, "Gestor", $conn, $idContrato, $gdb);

function editarSupervisores($arraySupervisores, $tipo, $conn, $idContrato, $gdb) {    
    $gdb->open("DELETE FROM contratoXsupervisor 
                    WHERE idContrato = $idContrato AND tipoSupervisor = '$tipo'", 1);

    if (empty($arraySupervisores)) {
        echo "Array de supervisores está vazio.";

    } else {
        foreach ($arraySupervisores as $nomeSupervisores) {
            $gdb->open("SELECT idSupervisor 
                        FROM supervisores 
                        WHERE upper(nomeSupervisor) = upper('$nomeSupervisores')", 1);
            if($gdb->linhas == 1 ){
                $idSupervisor = $gdb->gs['IDSUPERVISOR'][0];
                $gdb->open("INSERT INTO contratoXsupervisor (idSupervisor,
                                                        idContrato,
                                                        tipoSupervisor) 
                                                    VALUES ('$idSupervisor',  
                                                            '$idContrato',
                                                            '$tipo')", 1);
            } 
        }
    }
}

function editarSecretarias($arraySecretarias, $conn, $idContrato, $gdb) {
    $gdb->open("DELETE FROM contratoXsecretaria 
                            WHERE idContrato = $idContrato", 1);
    
    foreach ($arraySecretarias as $secretarias) {
        $gdb->open("SELECT idSecretaria 
                    FROM secretarias 
                    WHERE upper(nomeSecretaria) = upper('$secretarias') OR upper(siglaSecretaria) = upper('$secretarias')", 1);
        if($gdb->linhas == 1 ){
            $idSecretaria = $gdb->gs['IDSECRETARIA'][0];
            
            $gdb->open("INSERT INTO contratoXsecretaria (idSecretaria,
                                                      idContrato) 
                                                VALUES ('$idSecretaria',
                                                        '$idContrato')", 1);
        } 
    }
}



//Pegando ID do ultimo contrato inserido
$gdb->open("SELECT idContrato
              FROM contratos
             WHERE upper(nomeComercial) = upper('$nomeComercial') ",1);
$idContrato = $gdb->gs['IDCONTRATO'][0];

//Enviando Documentos para o wincp e criando variaveis de nomes e path
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['documentos'])) {
    $uploadDirectory = "/var/www/html/desenvolvimento/desenv4/pgs_fim/CadastroContratos/documentos/";

    foreach ($_FILES['documentos']['name'] as $key => $filename) {
        $fileTmpPath = $_FILES['documentos']['tmp_name'][$key];
        $fileId = bin2hex(random_bytes(16));
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $filePath = $uploadDirectory . $fileId . '.' . $extension;
        print_r("O FILEPATH É: $filePath");

        if ($_FILES['documentos']['error'][$key] == 0 && move_uploaded_file($fileTmpPath, $filePath)) {
            echo "Arquivo $filename enviado com sucesso!<br>";

            //Inserindo dados na tabela documento
            $caminhoArquivo = "/var/www/html/desenvolvimento/desenv4/pgs_fim/CadastroContratos/documentos/" . $fileID;
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
                        VALUES ('Editou o Contrato Arquivado',
                                '$idUsuario',
                                '$current_time',
                                '$nomeUsual')");





// header('Location: http://192.168.12.4/desenvolvimento/desenv4/pgs_fim/TelaArquivados/');

?>