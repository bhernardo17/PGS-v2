<?php
include '../db/connect.php';
include_once('../db/gdb_mysql.php');
if(!isset($_SESSION)) {
    session_start();
}


$gdb = new gdb();

$success = true;
$nomeComercial = $_POST['nomeComercial'];
$vigenciaInicial = $_POST['vigenciaInicial'];
$vigenciaFinal = $_POST['vigenciaFinal'];
$infoContratuais = $_POST['infoContratuais'];
$classContrato = $_POST['classContrato'];
$nomeUsual = $_POST['nomeUsual'];
$objetoContrato = $_POST['objetoContrato'];
$observacaoContrato = $_POST['observacaoContrato'];
$fornecedor = $_POST['fornecedor'];
$dotacao = $_POST['dotacao'];
$admSuporte = $_POST['admSuporte'];


$custoAnual = $_POST['custoAnual'];
$custoAnualFloat = floatval(str_replace(',', '.', $custoAnual));
$custoMensal = $_POST['custoMensal'];
$custoMensalFloat = floatval(str_replace(',', '.', $custoMensal));


$secretaria = $_POST['secretaria'];
$arraySecretarias = array_map('trim', explode(',', $secretaria));

$nomesupervisores = $_POST['supResponsavel'];
$tiposupervisores = $_POST['supStatus'];

// $superEgov = $_POST['superEgov'];
// $arraySuperEgov = array_map('trim', explode(',', $superEgov));

// $superFiscal = $_POST['superFiscal'];
// $arraySuperFiscal = array_map('trim', explode(',', $superFiscal));

// $superGestor = $_POST['superGestor'];
// $arraySuperGestor = array_map('trim', explode(',', $superGestor));

// function inserirSupervisores($arraySupervisores, $tipo, $gdb, $idContrato) {
//     foreach ($arraySupervisores as $nomeSupervisor) {
//         $matriculaSupervisor = intval($nomeSupervisor);
//         $gdb->open("SELECT idSupervisor
//                     FROM supervisores
//                     WHERE upper(nomeSupervisor) = upper('$nomeSupervisor') OR matriculaSupervisor = $matriculaSupervisor", 1);

//         if ($gdb->linhas == 1) {
//             $idSupervisor = $gdb->gs['IDSUPERVISOR'][0];
//             $sql3 = "INSERT INTO contratoXsupervisor (idSupervisor, idContrato, tipoSupervisor)
//                      VALUES ('$idSupervisor', '$idContrato', '$tipo')";

//             if (!$gdb->open($sql3)) {
//                 throw new Exception("Erro ao cadastrar supervisor: $nomeSupervisor");
//             }
//         }
//     }
// }

function inserirSecretarias($arraySecretarias, $gdb, $idContrato) {
    foreach ($arraySecretarias as $nomeSecretaria) {
        $gdb->open("SELECT idSecretaria
                    FROM secretarias
                    WHERE upper(siglaSecretaria) = upper('$nomeSecretaria')
                       OR upper(nomeSecretaria) = upper('$nomeSecretaria')", 1);

        if ($gdb->linhas == 1) {
            $idSecretaria = $gdb->gs['IDSECRETARIA'][0];
            $sql4 = "INSERT INTO contratoXsecretaria (idSecretaria, idContrato)
                     VALUES ('$idSecretaria', '$idContrato')";

            if (!$gdb->open($sql4)) {
                throw new Exception("Erro ao cadastrar secretaria: $nomeSecretaria");
            }
        } else {
            throw new Exception("Secretaria não encontrada: $nomeSecretaria");
        }
    }
}

try {
    $gdb->open("START TRANSACTION");

    // pegando id do fornecedor pelo nome
    $gdb->open("SELECT idFornecedor
                FROM fornecedor
                WHERE upper(nomeFornecedor) = upper('$fornecedor') OR upper(razaoFornecedor) = upper('$fornecedor')", 1);

    if ($gdb->linhas == 1) {
        $idFornecedor = $gdb->gs['IDFORNECEDOR'][0];

        // insert no banco (dados gerais)
        $sql = "INSERT INTO contratos (vigenciaInicial, vigenciaFinal, custoAnual, custoMensal, infoContratuais, observacaoContrato, objetoContrato, nomeUsual, nomeComercial, classificacaoContrato, idFornecedor, dotacao, admSuporte)
                VALUES ('$vigenciaInicial', '$vigenciaFinal', '$custoAnualFloat', '$custoMensalFloat', '$infoContratuais', '$observacaoContrato', '$objetoContrato', '$nomeUsual', '$nomeComercial', '$classContrato', '$idFornecedor', '$dotacao', '$admSuporte')";

        $CadastroContrato = $gdb->open($sql);

        if (!$CadastroContrato) {
            throw new Exception("Erro ao cadastrar contrato");
        }

        //enviando os documentos
        // if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['documentos']) && !empty($_FILES['documentos']['name'][0])) {
        //     $uploadDirectory = "/var/www/sistemas/pgs/CadastroContratos/documentos/";

        //     foreach ($_FILES['documentos']['name'] as $key => $filename) {
        //         $fileTmpPath = $_FILES['documentos']['tmp_name'][$key];
        //         $fileId = bin2hex(random_bytes(16));
        //         $extension = pathinfo($filename, PATHINFO_EXTENSION);
        //         $filePath = $uploadDirectory . $fileId . '.' . $extension;
        //         print_r("O FILEPATH É: $filePath");

        //         if ($_FILES['documentos']['error'][$key] == 0 && move_uploaded_file($fileTmpPath, $filePath)) {
        //             echo "Arquivo $filename enviado com sucesso!<br>";

        //             // dando insert com os dados de path do documento
        //             $sql2 = "INSERT INTO documentos (idContrato, caminhoDocumento, nomeDocumento, nomeAntigo)
        //                      VALUES ('$idContrato', '$filePath', '$fileId', '$filename')";

        //             $CadastroDocumentos = $gdb->open($sql2);

        //             if (!$CadastroDocumentos) {
        //                 throw new Exception("Erro ao cadastrar documentos");
        //             }
        //         } else {
        //             throw new Exception("Erro ao mover arquivo $filename");
        //         }
        //     }
        // }

        // inserirSupervisores($arraySuperEgov, "Fiscal E-Gov", $gdb, $idContrato);
        // inserirSupervisores($arraySuperFiscal, "Fiscal", $gdb, $idContrato);
        // inserirSupervisores($arraySuperGestor, "Gestor", $gdb, $idContrato);
        
        $gdb->open("SELECT idContrato
                    FROM contratos
                    WHERE upper(nomeComercial) = upper('$nomeComercial')", 1);
        $idContrato = $gdb->gs['IDCONTRATO'][0];

        inserirSecretarias($arraySecretarias, $gdb, $idContrato);


        // Itera sobre os arrays para inserir os valores na tabela
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
                // $gdb->open("SELECT idContrato FROM contratos ORDER BY idContrato DESC LIMIT 1");
                // $idContrato = $gdb->gs['IDCONTRATO'][0];

                // echo "<script>alert('idContrato antigo: $idContrato');</script>";
                // $novoidContrato = $idContrato +1;
                // echo "<script>alert('idContrato novo: $novoidContrato');</script>";
    
                // cadastro no banco
                $supervisoresSQL = "INSERT INTO contratoXsupervisor (idContrato, idSupervisor, tipoSupervisor) 
                                VALUES ('$idContrato', '$idSupervisor', '$tiposupervisor')";
                $CADsuper = $gdb->open($supervisoresSQL);
                
                
                if (!$CADsuper) {
                } else {
                    echo "Supervisor $nomesupervisor cadastrado com sucesso.<br>";
                }
            }
        } else {
            throw new Exception("Dados não recebidos corretamente.");
        }  

        // COMMIT envia todos os SQLS que foram feitos até agora, de uma vez
         $gdb->open("COMMIT");
      

        // regustri de auditoria dps commit
        $idUsuario = $_SESSION["idUsuario"];
        date_default_timezone_set('America/Sao_Paulo');
        $current_time = date('d-m-Y H:i:s');

        $auditoriaSql = "INSERT INTO auditoria (tipoInteracao, idUsuario, horaAuditoria, nomeDoAlvo)
                         VALUES ('Cadastrou o Contrato', '$idUsuario', '$current_time', '$nomeUsual')";

        if (!$gdb->open($auditoriaSql)) {
            //confirma auditoria e da redirect
            echo "<script>alert('Cadastro realizado com sucesso, mas houve um erro ao registrar a auditoria'); window.location.href = 'https://pgs.pmf.sc.gov.br/CadastroContratos/#';</script>";
        } else {
            echo "<script>alert('Cadastro realizado com sucesso e auditoria registrada!'); window.location.href = 'https://pgs.pmf.sc.gov.br/CadastroContratos/#';</script>";
        }

    } else {
        throw new Exception("Fornecedor não encontrado");
    }
} catch (Exception $e) {
    // ROLLBACK cancela todos os SQL feitos a te agora, oq so acontece caso tenha uma Exception, dada pelo Throw Exception
    $gdb->open("ROLLBACK");
    $success = false;
    echo "<script>alert('" . $e->getMessage() . "'); window.location.href = 'https://pgs.pmf.sc.gov.br/CadastroContratos/#';</script>";
}
?>