<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.min.js" integrity="sha512-L0Shl7nXXzIlBSUUPpxrokqq4ojqgZFQczTYlGjzONGTDAcLremjwaWv5A+EDLnxhQzY5xUZPWLOLqYRkY0Cbw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>

<?php
include_once("/home/www/sistemas/pgs/db/gdb_mysql.php");
include("/home/www/sistemas/pgs/db/connect.php");

$gdb = new gdb();

// Consulta SQL para buscar dados do relatório da view vw_relatorio_contratos
$gdb->open('SELECT 
    Nome_Usual AS nome, 
    Valor_Anual, 
    Valor_Mensal, 
    Vigencia_Inicial, 
    Vigencia_Final, 
    Fornecedor, 
    Info_Contratuais, 
    Objeto, 
    Gestores, 
    Fiscais, 
    Secretaria, 
    Categoria 
FROM vw_relatorio_contratos 
ORDER BY Vigencia_Final ASC;');

// Verifica se há dados
if ($gdb->linhas > 0) {
    $resultadosContratos = $gdb->gs;

    // Inicializa totais
    $totalAnual = 0;
    $totalMensal = 0;

    // Calcula os totais
    foreach ($resultadosContratos['VALOR_ANUAL'] as $valorAnual) {
        $totalAnual += $valorAnual;
    }

    foreach ($resultadosContratos['VALOR_MENSAL'] as $valorMensal) {
        $totalMensal += $valorMensal;
    }
}
?>

<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <a href="#" onclick="toggleSidebar()">☰</a>
        <img src="../imagens/icondash.jpg" class="icondash" style="width: 50%;">
    </div>
    <nav>
        <a href="../TelaDashboard/#" class="icon-middle"> 
            <span class="material-symbols-outlined">grid_view</span><span class="icon-text"> Dashboard</span>
        </a>
        <a href="../TelaCadastros/#" class="icon-middle"> 
            <span class="material-symbols-outlined">how_to_reg</span><span class="icon-text"> Cadastro</span>
        </a>
        <a href="../CadastroContratos/#" class="icon-middle"> 
            <span class="material-symbols-outlined">add</span><span class="icon-text">Adicionar</span>
        </a>
        <a href="../TelaAtivos/#" class="icon-middle"> 
            <span class="material-symbols-outlined">contract</span><span class="icon-text"> Contratos</span>
        </a>
        <a href="../TelaArquivados/#" class="icon-middle"> 
            <span class="material-symbols-outlined">inventory_2</span><span class="icon-text"> Arquivados</span>
        </a>
        <a href="../relatorio/#" class="icon-middle"><span class="material-symbols-outlined">summarize</span><span class="icon-text">Relatório </span></a>
        
    </nav>
    <div class="bottom-icons">
        <a href="../Auditoria/" class="icon-bottom">
            <span class="material-symbols-outlined">update</span><span class="icon-text"> Auditoria</span>
        </a>
        <a href="../db/logout.php" onclick="return confirmLogout();" class="icon-text">
            <i class="fa fa-sign-out"></i><span class="material-symbols-outlined">logout</span>
        </a>
    </div>
</div>

<div class="topo">
<p style="color: rgba(43, 43, 100, 1); margin-top: 2%; margin-left: 1.5%; font-size: 44px;">Relatório de Contratos PGS</p> 
<button class="btn btn-primary btn-imprimir no-print" onclick="imprimirDiv('panel-relatorio-contratos')">Imprimir Relatório</button>
<button class="btn btn-success no-print" 
        style="margin-left: 88%; margin-top: -6%;" 
        onclick="exportarExcel('relatorio-contratos-table')">
    Exportar para Excel
</button>
</div>



<div class="panel" id="panel-relatorio-contratos">   
    <div style="flex-direction: row;">     
        <table style="width: 80%; margin-left: 1%; margin-top: -2%;" id="relatorio-contratos-table" class="table table-striped custom-table">
            <thead>
                <tr>
                    <th><strong>Nome Usual</strong></th>
                    <th><strong>Valor Anual</strong></th>
                    <th><strong>Valor Mensal</strong></th>
                    <th><strong>Vigência Inicial</strong></th>
                    <th><strong>Vigência Final</strong></th>
                    <th><strong>Fornecedor</strong></th>
                    <th><strong>Info Contratuais</strong></th>
                    <th><strong>Objeto</strong></th>
                    <th><strong>Gestores</strong></th>
                    <th><strong>Fiscais</strong></th>
                    <th><strong>Secretaria</strong></th>
                    <th><strong>Categoria</strong></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($resultadosContratos)) {
                    foreach ($resultadosContratos['NOME'] as $i => $value) {
                        echo "<tr>";
                        echo "<td>" . $value . "</td>";
                        echo "<td>" . number_format($resultadosContratos['VALOR_ANUAL'][$i], 2, ',', '.') . "</td>";
                        echo "<td>" . number_format($resultadosContratos['VALOR_MENSAL'][$i], 2, ',', '.') . "</td>";
                        echo "<td>" . date('d/m/Y', strtotime($resultadosContratos['VIGENCIA_INICIAL'][$i])) . "</td>";
                        echo "<td>" . date('d/m/Y', strtotime($resultadosContratos['VIGENCIA_FINAL'][$i])) . "</td>";
                        echo "<td>" . $resultadosContratos['FORNECEDOR'][$i] . "</td>";
                        echo "<td>" . $resultadosContratos['INFO_CONTRATUAIS'][$i] . "</td>";
                        echo "<td>" . $resultadosContratos['OBJETO'][$i] . "</td>";
                        echo "<td>" . $resultadosContratos['GESTORES'][$i] . "</td>";
                        echo "<td>" . $resultadosContratos['FISCAIS'][$i] . "</td>";
                        echo "<td>" . $resultadosContratos['SECRETARIA'][$i] . "</td>";
                        echo "<td>" . $resultadosContratos['CATEGORIA'][$i] . "</td>";
                        echo "</tr>";
                    }

                    // Exibe os totais
                    echo "<tr class='table-total'>";
                    echo "<td><strong>Total:</strong></td>";
                    echo "<td>Anual: <strong>" . number_format($totalAnual, 2, ',', '.') . "</strong></td>";
                    echo "<td>Mensal: <strong>" . number_format($totalMensal, 2, ',', '.') . "</strong></td>";
                    echo "<td colspan='9'></td>"; // Preenche as colunas restantes
                    echo "</tr>";
                } else {
                    echo "<tr><td colspan='12'>Nenhum contrato encontrado</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>


<script>
function exportarExcel(tableId) {
    var table = document.getElementById(tableId);
    var wb = XLSX.utils.table_to_book(table, { sheet: "Relatório" });
    XLSX.writeFile(wb, "RelatorioContratos.xlsx");
}

function imprimirDiv(divId) {
    var divContents = document.getElementById(divId).innerHTML;
    var a = window.open('', '', 'height=600, width=800');
    a.document.write('<html>');
    a.document.write('<head><title>Relatório de Contratos PGS</title>');
    a.document.write('<style>');
    a.document.write('table, th, td { border: 1px solid black; border-collapse: collapse; padding: 8px; font-family: Arial, sans-serif; font-size: 12px; }');
    a.document.write('th { background-color: #f2f2f2; }');
    a.document.write('td { background-color: white; color: black; }');
    a.document.write('</style></head><body>');
    a.document.write(divContents);
    a.document.write('</body></html>');
    a.document.close();
    a.print();
}


</script>



<script src="script.js"></script>
</body>
</html>
