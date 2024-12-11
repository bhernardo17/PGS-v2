<?php

include("../db/protect3.php")

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.min.js" integrity="sha512-L0Shl7nXXzIlBSUUPpxrokqq4ojqgZFQczTYlGjzONGTDAcLremjwaWv5A+EDLnxhQzY5xUZPWLOLqYRkY0Cbw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php

include_once ("/home/www/sistemas/pgs/db/gdb_mysql.php");
include("/home/www/sistemas/pgs/db/connect.php");


$gdb = new gdb();

// Consulta para obter os dados da view vw_contratos_vencidos, incluindo a nova coluna 'situacaoContrato'
$gdb->open('SELECT nomeUsual as nome, vigenciaFinal as final, situacaoContrato as situacao FROM vw_contratos_vencidos ORDER BY vigenciaFinal DESC');

if ($gdb->linhas > 0) {
    $resultadosContratosVencidos = $gdb->gs;
}

$gdb->open('SELECT nomeUsual as nome, vigenciaFinal as final, dias_para_vencer, siglaSecretaria FROM contratos_vigencia ORDER BY vigenciaFinal ASC');

if ($gdb->linhas > 0) {
    $resultadosContratosAVencer = $gdb->gs;
}

$gdb->open('
    SELECT COUNT(*) AS TOTAL_FORNECEDORES_ATIVOS
    FROM (
        SELECT 
            f.idFornecedor
        FROM 
            fornecedor f
        LEFT JOIN 
            contratos c ON f.idFornecedor = c.idFornecedor
        GROUP BY 
            f.idFornecedor
        HAVING 
            SUM(CASE 
                    WHEN c.arquivado = 0 THEN 1 
                    ELSE 0 
                END) > 0
    ) AS fornecedoresAtivos
');
$totalFornecedoresAtivos = $gdb->gs['TOTAL_FORNECEDORES_ATIVOS'][0];





$gdb->open('SELECT sum(custoMensal) as totalMensal, sum(custoAnual) as totalAnual FROM contratos WHERE now() BETWEEN vigenciaInicial AND vigenciaFinal');
$totalMensal = $gdb->gs['TOTALMENSAL'][0];
$totalAnual = $gdb->gs['TOTALANUAL'][0];







$gdb->open('SELECT COUNT(*) AS total
FROM contratos_vigencia;
');
$totalAtivos = $gdb->gs['TOTAL'][0];



          
?>
<style>
.table-header {
    background-color: rgb(56, 56, 106);
    color: white; /* Ajuste a cor do texto para contraste, se necessário */
}

#custom-tooltip {
    position: absolute;
    background: rgba(0, 0, 0, 0.7);
    color: #fff;
    padding: 10px;
    border-radius: 3px;
    pointer-events: none;
    display: none;
    white-space: pre-wrap; /* Mantém quebras de linha */
    word-wrap: break-word; /* Quebra palavras longas se necessário */
    max-width: 400px; /* Ajuste conforme necessário */
    max-height: max-content; /* Ajuste conforme necessário */
    overflow-y: auto; /* Adiciona rolagem se necessário */
}

#btnDesativarTodos:hover {
    background-color: rgba(122, 131, 144, 1);
    color: #fff;
}


</style>


<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <a href="#" onclick="toggleSidebar()">☰</a><img src="../imagens/icondash.jpg" class="icondash" style="width: 50%;">
    </div>
    <a href="#" class="icon-middle"><span class="material-symbols-outlined">grid_view</span><span class="icon-text"> Dashboard</span></a>

    <a href="../TelaCadastros/#" class="icon-middle"><span class="material-symbols-outlined">how_to_reg</span><span class="icon-text"> Cadastro</span></a>

    <a href="../CadastroContratos/#" class="icon-middle"><span class="material-symbols-outlined">add</span><span class="icon-text" >Adicionar</span></a>

    <a href="../TelaAtivos/#" class="icon-middle"><span class="material-symbols-outlined">contract</span></i><span class="icon-text"> Contratos</span></a>

    <a href="../TelaArquivados/#" class="icon-middle"><span class="material-symbols-outlined">inventory_2</span><span class="icon-text"> Arquivados</span></a>

    <a href="../relatorio/#" class="icon-middle"><span class="material-symbols-outlined">summarize</span><span class="icon-text">Relatório </span></a>
        

    <div class="bottom-icons">
        <a href="../Auditoria/#" class="icon-bottom"><span class="material-symbols-outlined">update</span><span class="icon-text"> Histórico</span></a>

        <a href="../db/logout.php" onclick="return confirmLogout();" class="icon-text">
          <i class="fa fa-sign-out"></i><span class="material-symbols-outlined">logout</span>
        </a>
    </div>
</div>

<script>

let modalChart = null;

function confirmLogout() {
    if (confirm('Tem certeza que deseja sair?')) {
        return true; // Prossiga com o logout
    } else {
        return false; // Cancela o logout
    }
}

function openModal(idSecretaria) {
    console.log('Abrindo modal para a Secretaria com ID:', idSecretaria);
    document.getElementById('modal').style.display = 'block'; // Mostrar o modal

    // Fazer a requisição AJAX para buscar os dados do fornecedor
    var xhr8 = new XMLHttpRequest();
    xhr8.open('POST', 'buscarFornecedoresPorSecretaria.php', true);
    xhr8.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr8.onreadystatechange = function () {
        if (xhr8.readyState === 4 && xhr8.status === 200) {
            try {
                let responseData = JSON.parse(xhr8.responseText);

                if (responseData.IDFORNECEDOR && responseData.NOMEFORNECEDOR && responseData.VALORTOTALANUAL && responseData.CONTRATOS) {
                    let labelsBar = responseData.NOMEFORNECEDOR;
                    let dataBar = responseData.VALORTOTALANUAL.map(Number);
                    let contratosBar = responseData.CONTRATOS;
                    var nomeSecretariaNaoTratado = responseData.NOMESECRETARIA;
                    var nomeSecretaria3 = nomeSecretariaNaoTratado[0];

                    let backgroundColorsBar = [];
                    for (let i = 0; i < labelsBar.length; i++) {
                        backgroundColorsBar.push(getRandomColor());
                    }

                    // Destruir o gráfico antigo, se existir
                    if (modalChart) {
                        modalChart.destroy();
                    }

                    // Criar um novo gráfico
                    const ctx = document.getElementById('testeFornecedor').getContext('2d');
                    modalChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labelsBar,
                            datasets: [{
                                label: '',
                                data: dataBar,
                                backgroundColor: backgroundColorsBar,
                                borderColor: backgroundColorsBar.map(color => color.replace('0.2', '1')),
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    type: 'logarithmic', // Define a escala logarítmica
                                    beginAtZero: true,
                                    min: 10000, // Valor mínimo visível no eixo Y
                                    max: 10000000, // Valor máximo visível no eixo Y
                                    ticks: {
                                        color: 'white',
                                        callback: function(value) {
                                            const tickValues = [10000, 100000, 1000000, 10000000];
                                            if (tickValues.includes(value)) {
                                                return 'R$ ' + value.toLocaleString('pt-BR', { minimumFractionDigits: 2 });
                                            }
                                            return ''; // Não mostrar ticks intermediários
                                        }
                                    }
                                },
                                x: {
                                    ticks: {
                                        color: 'white'
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    labels: {
                                        color: 'white'
                                    }
                                },
                                title: {
                                    display: true,
                                    text: `Relação de Contratos por Fornecedores`,
                                    color: 'white'
                                },
                                tooltip: {
                                    callbacks: {
                                        title: function(context) {
                                            return context[0].label; // Nome do fornecedor
                                        },
                                        label: function(context) {
                                            let value = context.raw;
                                            return 'Valor Total: R$ ' + value.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                                        },
                                        footer: function(context) {
                                            let index = context[0].dataIndex;
                                            let contratos = contratosBar[index];
                                            
                                            // Quebrar a string dos contratos em linhas e numerá-las
                                            let contratosList = contratos.split('; ').map((contrato, i) => `${i + 1}. ${contrato}`).join('\n');
                                            
                                            return 'Contrato e Valor:\n' + contratosList;
                                        }
                                    }
                                }
                            },
                            layout: {
                                padding: {
                                    left: 50,
                                    right: 50,
                                    top: 0,
                                    bottom: 0
                                }
                            },
                            responsive: true,
                            maintainAspectRatio: false
                        }
                    });

                } else {
                    console.error('Estrutura dos dados recebidos não é esperada:', responseData);
                }
            } catch (e) {
                console.error('Erro ao analisar JSON:', e);
            }
            document.getElementById("modalTitle").innerText = nomeSecretaria3;
            console.log('risos', nomeSecretaria3);
        }
    };

    // Enviar o ID da secretaria via POST
    xhr8.send('idSecretaria=' + encodeURIComponent(idSecretaria));


}


function closeModal() {
    document.getElementById('modal').style.display = 'none'; // Ocultar o modal
}


</script>

<!-- Modal -->
<!-- Modal -->
<div id="modal" style="display:none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.75); z-index: 1000; overflow: auto;">
    <div style="background-color:rgba(43, 43, 100, 0.9); color:white; margin: 5% auto; border-radius: 15px; padding: 20px; width: 95%; max-width: 1200px; max-height: 90%; overflow: auto;">
        <span onclick="closeModal()" style="cursor:pointer; float:right; font-size: 24px; line-height: 1; color: white;">&times;</span>
        <h2 id="modalTitle" style="text-align: center;">Teste</h2>
        <canvas id="testeFornecedor" width="900" height="450" style="width: 100%; height: auto;"></canvas>
    </div>
</div>



<img src="imagens/dashboard.jpg"  class="logodash">  
<!-- Modal para exibir o gráfico de fornecedores -->

<div class="section">
    <div class="primeiraLinha">
        <div class="panel" id="panel2">
            <canvas id="graficoValoresAnuais" height="277" ></canvas>
        </div>
        
        <div class="panel" id="panel1">
            <canvas id="grafico1"></canvas>
            <div id="custom-tooltip"></div>
        </div>
        <!-- <button id="someButton">Abrir Modal Teste</button> -->


          
    </div>
    <div class="coluna">
            <div class="info-container">
                <div class="info-box">
                    <span class="material-symbols-outlined">
                        pallet
                        </span>
                    <h4>Fornecedores</h4>
                    <h4>Ativos</h4>
                    <p> <?php  echo $totalFornecedoresAtivos  ?> </p>        
                </div>
                <div class="info-box">
                    <span class="material-symbols-outlined">paid</span>
                    <h4>Gastos</h4>
                    <select id="gasto-select" data-mensal="<?php echo $totalMensal; ?>" data-anual="<?php echo $totalAnual; ?>" onchange="updateGastos()">
                        <option value="mensal">Mensal</option>
                        <option value="anual">Anual</option>
                    </select>
                    <p id="gasto-display"><?php echo "R$ " . number_format($totalMensal, 2, ',', '.'); ?></p>
                </div>
                <div class="info-box">
                    <span class="material-symbols-outlined">
                        contract
                        </span>
                    <h4>Contratos Ativos</h4>
                    <p><?=$totalAtivos; ?></p>
                </div>
            </div>
            <div class="panel" id="panel4">
                <canvas id="grafico2" width="450" height="517"></canvas>
                <button id="btnDesativarTodos" style="position: absolute; top: 65%; font-size:13px; left: 18.2%; padding: 0.1% 0.4%; background-color: rgba(175, 188, 207, 0.8); color: white; border: none; border-radius: 5px; cursor: pointer;">
                 Desativar Todos</button>             
            </div>
            <button id="btnTop10" style="position: absolute; top: 61%; font-size:13px; left: 18.2%; padding: 0.1% 0.4%; background-color: rgba(175, 188, 207, 0.8); color: white; border: none; border-radius: 5px; cursor: pointer;">
                Top 10 Fornecedores
            </button>
            <button id="btnMostrarTodos" style="position: absolute; top: 69%; font-size:13px; left: 18.2%; padding: 0.1% 0.4%; background-color: rgba(175, 188, 207, 0.8); color: white; border: none; border-radius: 5px; cursor: pointer;">
                Mostrar Todos
            </button>
            <div class="panel" id="panel3">
                <canvas id="grafico3" width="450" height="517"></canvas>
            </div>
    </div>

    <div class=terceiraLInha>
        
        <div class="panel" id="panel5">
            <p class="fw-bold" style="position:absolute; margin-left:19%; margin-top:0.5%;">Contratos a Vencer</p>
            <div style="flex-direction:row">
                <table style="width: 99%; margin-left: 0.6%; margin-top:4%;" id="contratos-vencer-table" class="table table-striped">
                    <thead>
                        <tr class="table-header">
                            <th>Nome Usual</th>
                            <th>Sigla Secretaria</th>
                            <th>Vigência Final</th>
                            <th>Dias para Vencer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Loop para exibir os resultados da consulta na tabela
                        $contrato = $resultadosContratosAVencer;
                        foreach ($contrato['NOME'] as $i => $value) {
                            if ($contrato['DIAS_PARA_VENCER'][$i] > 90) {
                                echo "<tr class='table-success'>";
                            } elseif ($contrato['DIAS_PARA_VENCER'][$i] > 60 && $contrato['DIAS_PARA_VENCER'][$i] <= 90) {
                                echo "<tr class='table-warning'>";
                            } elseif ($contrato['DIAS_PARA_VENCER'][$i] <= 60) {
                                echo "<tr class='table-danger'>";
                            } else {
                                echo "<tr>"; // Caso queira adicionar uma classe padrão para os outros casos
                            }
                            
                            echo "<td>" . $value . "</td>";
                            echo "<td>" . $contrato['SIGLASECRETARIA'][$i] . "</td>";
                            // Formatação da data para dd-mm-yyyy
                            $vigenciaFinalFormatted = date('d/m/Y', strtotime($contrato['FINAL'][$i]));
                            echo "<td>" . $vigenciaFinalFormatted . "</td>";
                            echo "<td>" . $contrato['DIAS_PARA_VENCER'][$i] . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="panel" id="panel6">
            <p class="fw-bold" style="position:absolute; margin-left:13%; margin-top:0.5%;"> Contratos Fora de Vigência</p>
                <div style="flex-direction:row">     
                    <table style="width: 98%; margin-left: 1%; margin-top:5%;" id="contratos-vencidos-table" class="table table-striped custom-table">
                        <thead>
                            <tr>
                                <th>Nome Usual</th>
                                <th>Vigência Final</th>
                                <th>Situação</th> <!-- Nova coluna Situação -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Loop para exibir os resultados da consulta na tabela
                            $contrato = $resultadosContratosVencidos;
                            foreach ($contrato['NOME'] as $i => $value) {
                                echo "<tr>";
                                echo "<td>" . $value . "</td>";
                                
                                // Formatação da data para dd-mm-yyyy
                                $vigenciaFinalFormatted = date('d/m/Y', strtotime($contrato['FINAL'][$i]));
                                echo "<td>" . $vigenciaFinalFormatted . "</td>";
                                
                                // Exibindo a situação do contrato
                                echo "<td>" . $contrato['SITUACAO'][$i] . "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
         </div>
            <!-- <div class="panel" id="panel7">
                
            </div> -->
    </div>  
</div>    

    
</div>




<script>
         function numberFormat(number, decimals, decPoint, thousandsSep) {
            number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep,
                dec = (typeof decPoint === 'undefined') ? '.' : decPoint,
                s = '',
                toFixedFix = function(n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + (Math.round(n * k) / k).toFixed(prec);
                };

            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }

        function updateGastos() {
            const select = document.getElementById('gasto-select');
            const display = document.getElementById('gasto-display');
            const mensal = parseFloat(select.dataset.mensal);
            const anual = parseFloat(select.dataset.anual);
            
            let value = (select.value === 'mensal') ? mensal : anual;
            display.textContent = "R$ " + numberFormat(value, 2, ',', '.');
        }

        // Chama a função ao carregar a página para garantir que o valor inicial esteja correto
        window.onload = function() {
            updateGastos();
        }
</script>


</main>
    <script src="script.js"></script>
</body>
</html>
