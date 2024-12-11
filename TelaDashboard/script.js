document.addEventListener('DOMContentLoaded', (event) => {
    buscarTotalPorFornecedor();
    buscarContratosPorSecretaria();
    carregarSecretarias();
    buscarEvolucaoValoresContratos();
    buscarValoresTempoContratos();
    buscarValoresAnuaisPorSecretaria();
    buscarFornecedoresPorSecretaria();
});


function getRandomColor() {
    const letters = '0123456789ABCDEF';
    let color = '#';
    for (let i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}


const fixedColors = {
    'SMG': '#FF5733',   // Vermelho
    'GAPRE': '#33FF57', // Verde
    'CGM': '#3357FF',   // Azul
    'PGM': '#FF33A1',   // Rosa
    'SMA': '#FFA500',    // Laranja
    'SEMAS': '#8A2BE2', // Azul Violeta
    'SMCC': '#FF4500',  // Laranja Vermelho
    'SMCAN': '#2E8B57', // Verde Mar
    'SME': '#FFD700',   // Amarelo
    'SMHDU': '#6A5ACD', // Azul Claro
    'SMLCP': '#20B2AA', // Verde Água
    'SMLMU': '#FF6347', // Tomate
    'SMMADS': '#4169E1', // Azul Royal
    'SMS': '#FF1493',   // Rosa Forte
    'SMSOP': '#7FFF00', // Verde Limão
    'SMTI': '#FF8C00',  // Laranja Escuro
    'SMTCE': '#00BFFF', // Azul Céu
    'SMCS': '#FF69B4',  // Rosa
    'CSG': '#A0522D',   // Marrom
    'SMDECT': '#C71585', // Rosa Escuro
    'IPREF': '#FFDAB9', // Pêssego
    'COMCAP': '#B0E0E6', // Azul Pálido
    'IPUF': '#F0E68C',  // Caqui
    'IGEOF': '#DDA0DD', // Lavanda
    'FME': '#F08080',   // Vermelho Claro
    'FCFFC': '#E6E6FA', // Lavanda
    'FLORAM': '#FFFACD', // Limão Claro
    'SOMAR': '#ADD8E6', // Azul Claro
    'SMF': '#90EE90',   // Verde Claro
    'GMF': '#D2691E',   // Chocolate
    'SMPIU': '#FFB6C1', // Rosa Claro
    'Des': '#C0C0C0',   // Cinza
    'FMS': '#4682B4',   // Azul Aço
    'FMAS': '#8B0000',  // Vermelho Escuro
    'Pró': '#808080',   // Cinza Escuro
};

// Função para obter a cor da secretaria
function getColorBySecretaria(secretaria) {
    return fixedColors[secretaria] || '#FFFFFF'; // Retorna branco se a secretaria não estiver no mapeamento
}


function buscarEvolucaoValoresContratos() {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'buscarEvolucaoValoresContratos.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            try {
                let responseData = JSON.parse(xhr.responseText);

                // Log para verificar os dados recebidos
                console.log("Dados recebidos do PHP:", responseData);

                if (responseData && Array.isArray(responseData) && responseData.length > 0) {
                    let datas = [];
                    let valoresAnoAtual = [];
                    let valoresAnoAnterior = [];
                    let qtdContratosPorMesAtual = [];
                    let qtdContratosPorMesAnterior = [];

                    // Inicializa os dados dos meses com valores zerados
                    for (let i = 0; i < 12; i++) {
                        datas.push(obterNomeMes(i + 1));
                        valoresAnoAtual.push(0);
                        valoresAnoAnterior.push(0);
                        qtdContratosPorMesAtual.push(0);
                        qtdContratosPorMesAnterior.push(0);
                    }

                    responseData.forEach(item => {
                        let mes = parseInt(item.mes);
                        let ano = parseInt(item.ano);

                        if (ano === new Date().getFullYear()) {
                            valoresAnoAtual[mes - 1] = parseFloat(item.totalValorMensal);
                            qtdContratosPorMesAtual[mes - 1] = item.qtdContratos;
                        } else if (ano === (new Date().getFullYear() - 1)) {
                            valoresAnoAnterior[mes - 1] = parseFloat(item.totalValorMensal);
                            qtdContratosPorMesAnterior[mes - 1] = item.qtdContratos;
                        }
                    });

                    // Logs para verificar se os dados foram separados corretamente
                    console.log("Datas:", datas);
                    console.log("Valores Ano Atual:", valoresAnoAtual);
                    console.log("Valores Ano Anterior:", valoresAnoAnterior);

                    const ctx = document.getElementById('grafico3');

                    // Verifique se o elemento gráfico existe no DOM
                    if (!ctx) {
                        console.error("Elemento com id 'grafico3' não encontrado no DOM.");
                        return;
                    }

                    new Chart(ctx.getContext('2d'), {
                        type: 'line',
                        data: {
                            labels: datas,
                            datasets: [
                                {
                                    label: 'Evolução dos Valores dos Contratos (Ano Atual)',
                                    data: valoresAnoAtual,
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1,
                                    fill: true
                                },
                                {
                                    label: 'Evolução dos Valores dos Contratos (Ano Anterior)',
                                    data: valoresAnoAnterior,
                                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                    borderColor: 'rgba(255, 99, 132, 1)',
                                    borderWidth: 1,
                                    fill: true
                                }
                            ]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        color: 'white'
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
                                    text: 'Evolução dos Valores dos Contratos (Comparação com Ano Anterior)',
                                    color: 'white'
                                },
                                tooltip: {
                                    callbacks: {
                                        afterLabel: function(context) {
                                            const index = context.dataIndex;
                                            if (context.dataset.label.includes('Ano Atual')) {
                                                const qtdContratos = qtdContratosPorMesAtual[index];
                                                return qtdContratos ? `Contratos: ${qtdContratos}` : 'Sem contratos';
                                            } else {
                                                const qtdContratos = qtdContratosPorMesAnterior[index];
                                                return qtdContratos ? `Contratos: ${qtdContratos}` : 'Sem contratos';
                                            }
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
                    console.error('Dados recebidos do servidor estão vazios ou em formato incorreto.');
                }
            } catch (error) {
                console.error('Erro ao processar resposta do servidor:', error);
            }
        }
    };

    xhr.onerror = function () {
        console.error('Erro de conexão ao servidor.');
    };

    xhr.send();
}

// Função para obter o nome do mês em português
function obterNomeMes(numeroMes) {
    const meses = [
        'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
        'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
    ];
    return meses[numeroMes - 1]; // Arrays são baseados em zero, então subtrai 1 do número do mês
}

function buscarValoresAnuaisPorSecretaria() {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'buscarValoresAnuaisPorSecretaria.php', true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            try {
                let responseData = JSON.parse(xhr.responseText);

                if (responseData.IDSECRETARIA && responseData.NOMESECRETARIA && responseData.TOTALCUSTOANUAL) {
                    let labelsBar = responseData.NOMESECRETARIA;
                    let dataBar = responseData.TOTALCUSTOANUAL.map(Number);
                    let idsSecretaria = responseData.IDSECRETARIA; // IDs das secretarias

                    const ctx = document.getElementById('graficoValoresAnuais').getContext('2d');
                    const chart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labelsBar,
                            datasets: [{
                                label: '', // O rótulo do dataset foi removido
                                data: dataBar,
                                backgroundColor: labelsBar.map(getColorBySecretaria), // Usa as cores do mapeamento
                                borderColor: labelsBar.map(getColorBySecretaria).map(color => color.replace('0.2', '1')),
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    type: 'logarithmic',
                                    beginAtZero: true,
                                    min: 100000,
                                    max: 20000000,
                                    ticks: {
                                        color: 'white',
                                        callback: function(value) {
                                            const tickValues = [100000, 250000, 500000, 1000000, 2500000, 5000000, 10000000, 20000000];
                                            if (tickValues.includes(value)) {
                                                return 'R$ ' + value.toLocaleString('pt-BR', { minimumFractionDigits: 2 });
                                            }
                                            return '';
                                        },
                                        autoSkip: false
                                    },
                                    afterBuildTicks: function(scale) {
                                        const tickValues = [100000, 250000, 500000, 1000000, 2500000, 5000000, 10000000, 20000000];
                                        scale.ticks = tickValues.map(tick => ({
                                            value: tick,
                                            major: true
                                        }));
                                        return scale.ticks;
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
                                        color: 'white',
                                        usePointStyle: true,
                                        boxWidth: 0,
                                        boxHeight: 0,
                                        padding: 20
                                    },
                                    onClick: null // Desativa a função de ativar/desativar as barras ao clicar na legenda
                                },
                                title: {
                                    display: true,
                                    text: 'Valores Anuais dos Contratos por Secretaria',
                                    color: 'white'
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            let value = context.raw;
                                            return context.label + ': R$ ' + value.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
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
                            maintainAspectRatio: false,
                            onClick: function(event) {
                                var points = chart.getElementsAtEventForMode(event, 'nearest', { intersect: true }, true);
                                if (points.length) {
                                    var firstPoint = points[0];
                                    var label = chart.data.labels[firstPoint.index];
                                    var idSecretaria = idsSecretaria[firstPoint.index];
                                    openModal(idSecretaria); // Função para abrir o modal
                                }
                            }
                        }
                    });

                } else {
                    console.error('Estrutura dos dados recebidos não é esperada:', responseData);
                }
            } catch (e) {
                console.error('Erro ao analisar JSON:', e);
            }
        }
    };

    xhr.send();
}

// Função para buscar e exibir o gráfico filho
function buscarFornecedoresPorSecretaria() {
    var xhr8 = new XMLHttpRequest();
    xhr8.open('POST', 'buscarFornecedoresPorSecretaria.php', true);

    xhr8.onreadystatechange = function () {
        if (xhr8.readyState === 4 && xhr8.status === 200) {
            try {
                let responseData = JSON.parse(xhr8.responseText);

                if (responseData.IDFORNECEDOR && responseData.NOMEFORNECEDOR && responseData.VALORTOTALANUAL && responseData.CONTRATOS) {
                    let labelsBar = responseData.NOMEFORNECEDOR;
                    let dataBar = responseData.VALORTOTALANUAL.map(Number);
                    let contratosBar = responseData.CONTRATOS;

                    let backgroundColorsBar = [];
                    for (let i = 0; i < labelsBar.length; i++) {
                        backgroundColorsBar.push(getRandomColor());
                    }

                    const ctx = document.getElementById('testeFornecedor').getContext('2d');
                    const chart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labelsBar,
                            datasets: [{
                                label: 'Valores Anuais dos Contratos por Fornecedor',
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
                                    text: `X - Relação de Contratos por Fornecedores `,
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
        }
    };

    xhr8.send();
}


// Função para carregar as secretarias
function carregarSecretarias() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'buscarSecretarias.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            var secretarias = JSON.parse(xhr.responseText);
            var select = document.getElementById('selectSecretaria');
            
            // Limpar opções atuais do select
            select.innerHTML = '<option value="" disabled selected>Selecione a Secretaria</option>';
            
            // Adicionar as opções de secretarias ao select
            secretarias.forEach(function(secretaria) {
                var option = document.createElement('option');
                option.value = secretaria.idSecretaria;
                option.textContent = secretaria.siglaSecretaria;
                select.appendChild(option);
            });

            // Ativar o dropdown após carregar as opções
            select.disabled = false;
        } else {
            console.log('Erro ao carregar secretarias. Status: ' + xhr.status);
        }
    };
    xhr.send();
}

function toggleSidebar() {
    var sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('open');
}

function abrirModalSair() {
    document.getElementById("modalExit").style.display = "block";
    document.getElementById("body").style.backgroundColor = "rgba(0, 0, 0, 0.5)";
}

function fecharModal() {
    document.getElementById("modalExit").style.display = "none";
    document.getElementById("body").style.backgroundColor = "rgba(0, 0, 0, 0)";
}

document.querySelectorAll("#voltar").forEach(function (element) {
    element.addEventListener("click", function () {
        fecharModal(element.closest(".modoff").id);
    });
});

function buscarTotalPorFornecedor() {
    var xhr3 = new XMLHttpRequest();
    xhr3.open('POST', 'buscarTotalPorFornecedor.php', true);

    xhr3.onreadystatechange = function () {
        if (xhr3.readyState === 4 && xhr3.status === 200) {
            try {
                let responseData = JSON.parse(xhr3.responseText);

                if (responseData.NOME && responseData.VALOR) {
                    let labelsPie = [];
                    let dataPie = [];
                    let backgroundColorsPie = [];

                    for (let i = 0; i < responseData.NOME.length; i++) {
                        labelsPie.push(responseData.NOME[i]);
                        dataPie.push(parseFloat(responseData.VALOR[i]));

                        let color = i === 0 ? 'rgba(175, 188, 207, 1)' : getRandomColor();
                        backgroundColorsPie.push(color);
                    }

                    const ctx2 = document.getElementById('grafico2').getContext('2d');
                    const chartPie = new Chart(ctx2, {
                        type: 'pie',
                        data: {
                            labels: labelsPie,
                            datasets: [{
                                label: 'Contrato',
                                data: dataPie,
                                backgroundColor: backgroundColorsPie,
                                hoverOffset: 4
                            }]
                        },
                        options: {
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        color: 'white'
                                    },
                                    onClick: function(e, legendItem) {
                                        const index = legendItem.index;
                                        const chart = this.chart;
                                        const meta = chart.getDatasetMeta(0);

                                        meta.data[index].hidden = !meta.data[index].hidden;
                                        chart.update();
                                    }
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            let label = context.label || '';
                                            let value = context.raw || 0;
                                            value = value.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

                                            // Cálculo da porcentagem
                                            let total = context.dataset.data.reduce((acc, val) => acc + val, 0);
                                            let percentage = ((context.raw / total) * 100).toFixed(2);

                                            return `${label}: ${value} (${percentage}%)`;
                                        }
                                    }
                                },
                                title: {
                                    display: true,
                                    text: 'Distribuição dos Valores dos Contratos por Fornecedor',
                                    color: 'white',
                                    fontSize: 0
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
                        },
                        plugins: [
                            {
                                id: 'legend-line',
                                afterDraw: function (chart) {
                                    const { ctx, legend } = chart;
                                    const meta = chart.getDatasetMeta(0);
                                    const legendBox = legend.legendHitBoxes;
                                    const legendItems = legend.legendItems;
                        
                                    const lineLength = 38; // Comprimento fixo da linha de riscado
                                    const lineOffset = 0; // Espaço entre o quadrado e a linha
                        
                                    legendItems.forEach((legendItem, index) => {
                                        const chartData = meta.data[index];
                        
                                        if (chartData && chartData.hidden) {
                                            const textBox = legendBox[index];
                                            const boxSize = legendItems[index].lineWidth; // Tamanho do quadrado da legenda
                        
                                            const textX = textBox.left;
                                            const textY = textBox.top + textBox.height / 2; // Meio do quadrado
                                            const lineLeft = textX + boxSize + lineOffset; // Início da linha
                                            const lineRight = lineLeft + lineLength; // Fim da linha
                                            const lineY = textY; // Alinha a linha com o meio do texto
                        
                                            ctx.save();
                                            ctx.strokeStyle = 'rgba(255, 255, 255, 1)'; // Cor da linha
                                            ctx.lineWidth = 9; // Espessura da linha
                                            ctx.setLineDash([]); // Linha sólida
                        
                                            ctx.beginPath();
                                            ctx.moveTo(lineLeft, lineY); // Início da linha
                                            ctx.lineTo(lineRight, lineY); // Fim da linha
                                            ctx.stroke();
                                            ctx.restore();
                                        }
                                    });
                                }
                            }
                        ]
                        
                    });

                    // Função para desativar todos os fornecedores
                    document.getElementById('btnDesativarTodos').addEventListener('click', function() {
                        const meta = chartPie.getDatasetMeta(0);
                        const allHidden = meta.data.every(function(element) {
                            return element.hidden;
                        });
                        meta.data.forEach(function(element) {
                            element.hidden = !allHidden;
                        });
                        chartPie.update();
                    });

                    // Função para exibir somente os 10 fornecedores com maiores valores
                    document.getElementById('btnTop10').addEventListener('click', function() {
                        const meta = chartPie.getDatasetMeta(0);
                        const top10Indexes = [...dataPie]
                            .map((value, index) => ({ value, index }))
                            .sort((a, b) => b.value - a.value)
                            .slice(0, 10)
                            .map(item => item.index);
                        
                        meta.data.forEach(function(element, index) {
                            element.hidden = !top10Indexes.includes(index);
                        });
                        chartPie.update();
                    });

                    // Função para exibir todos os fornecedores novamente
                    document.getElementById('btnMostrarTodos').addEventListener('click', function() {
                        const meta = chartPie.getDatasetMeta(0);
                        meta.data.forEach(function(element) {
                            element.hidden = false;
                        });
                        chartPie.update();
                    });

                } else {
                    console.error('Estrutura dos dados recebidos não é esperada:', responseData);
                }
            } catch (e) {
                console.error('Erro ao analisar JSON:', e);
            }
        }
    };

    xhr3.send();
}




// Configura o gráfico e o tooltip
// function buscarContratosPorSecretaria() {
//     var xhr4 = new XMLHttpRequest();
//     xhr4.open('POST', 'buscarContratosPorSecretaria.php', true);

//     xhr4.onreadystatechange = function () {
//         if (xhr4.readyState === 4 && xhr4.status === 200) {
//             try {
//                 let responseData = JSON.parse(xhr4.responseText);

//                 if (responseData.SIGLASECRETARIA && responseData.QUANTIDADECONTRATOS && responseData.NOMESCONTRATOS) {
//                     let labelsBar = responseData.SIGLASECRETARIA;
//                     let dataBar = responseData.QUANTIDADECONTRATOS.map(Number);
//                     let nomesContratos = responseData.NOMESCONTRATOS;

//                     let backgroundColorsBar = dataBar.map((_, index) => index === 0 ? 'rgba(175, 188, 207, 1)' : getRandomColor());

//                     const ctx1 = document.getElementById('grafico1').getContext('2d');

//                     const chart = new Chart(ctx1, {
//                         type: 'bar',
//                         data: {
//                             labels: labelsBar,
//                             datasets: [{
//                                 label: 'Quantidade de Contratos por Secretaria',
//                                 data: dataBar,
//                                 borderWidth: 1,
//                                 backgroundColor: backgroundColorsBar,
//                                 borderColor: 'rgba(54, 162, 235, 1)',
//                                 nomesContratos: nomesContratos
//                             }]
//                         },
//                         options: {
//                             indexAxis: 'y',
//                             scales: {
//                                 y: {
//                                     beginAtZero: true,
//                                     ticks: {
//                                         color: 'white'
//                                     }
//                                 },
//                                 x: {
//                                     ticks: {
//                                         color: 'white'
//                                     }
//                                 }
//                             },
//                             plugins: {
//                                 legend: {
//                                     labels: {
//                                         color: 'white'
//                                     }
//                                 },
//                                 tooltip: {
//                                     enabled: false, 
//                                     external: function(context) {
//                                         const { tooltip } = context;
//                                         const tooltipEl = document.getElementById('custom-tooltip');
                                    
//                                         if (!tooltip.opacity) {
//                                             tooltipEl.style.display = 'none';
//                                             return;
//                                         }
                                    
//                                         const tooltipModel = tooltip;
//                                         const dataIndex = tooltipModel.dataPoints[0].dataIndex;
//                                         const label = labelsBar[dataIndex];
//                                         const quantidade = dataBar[dataIndex];
                                    
//                                         // Ajuste para separar os nomes dos contratos com base no novo separador "|"
//                                         let nomes = nomesContratos[dataIndex];
//                                         if (!nomes) {
//                                             nomes = 'Nenhum contrato disponível';
//                                         } else {
//                                             let nomesArray = nomes.split('|');
//                                             nomes = nomesArray.map((nome, index) => `${index + 1}. ${nome.trim()}`).join('<br>');
//                                         }
                                    
//                                         tooltipEl.innerHTML = `<div><strong>${label}:</strong> ${quantidade} contratos<br><strong>Contratos:</strong><br>${nomes}</div>`;
//                                         tooltipEl.style.display = 'block';
                                    
//                                         const chartRect = chart.canvas.getBoundingClientRect();
//                                         const tooltipX = chartRect.left + tooltipModel.caretX + window.scrollX + 10;
//                                         const tooltipY = chartRect.top + tooltipModel.caretY + window.scrollY;
                                    
//                                         tooltipEl.style.left = Math.min(tooltipX, chartRect.left + chartRect.width - tooltipEl.offsetWidth) + 'px';
//                                         tooltipEl.style.top = Math.min(tooltipY, chartRect.top + chartRect.height - tooltipEl.offsetHeight) + 'px';
//                                     }
//                                 }
//                             }
//                         }
//                     });

//                 } else {
//                     console.error('Estrutura dos dados recebidos não é esperada:', responseData);
//                 }
//             } catch (e) {
//                 console.error('Erro ao analisar JSON:', e);
//             }
//         }
//     };

//     xhr4.send();
// }

// Função para buscar contratos por secretaria
function buscarContratosPorSecretaria() {
    var xhr4 = new XMLHttpRequest();
    xhr4.open('POST', 'buscarContratosPorSecretaria.php', true);

    xhr4.onreadystatechange = function () {
        if (xhr4.readyState === 4 && xhr4.status === 200) {
            try {
                let responseData = JSON.parse(xhr4.responseText);

                if (responseData.SIGLASECRETARIA && responseData.QUANTIDADECONTRATOS && responseData.NOMESCONTRATOS) {
                    let labelsBar = responseData.SIGLASECRETARIA;
                    let dataBar = responseData.QUANTIDADECONTRATOS.map(Number);
                    let nomesContratos = responseData.NOMESCONTRATOS;

                    const ctx1 = document.getElementById('grafico1').getContext('2d');

                    const chart = new Chart(ctx1, {
                        type: 'bar',
                        data: {
                            labels: labelsBar,
                            datasets: [{
                                label: 'Quantidade de Contratos por Secretaria',
                                data: dataBar,
                                borderWidth: 1,
                                backgroundColor: labelsBar.map(getColorBySecretaria), // Usa as mesmas cores do mapeamento
                                borderColor: 'rgba(54, 162, 235, 1)',
                                nomesContratos: nomesContratos
                            }]
                        },
                        options: {
                            indexAxis: 'y',
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        color: 'white'
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
                                tooltip: {
                                    enabled: false,
                                    external: function(context) {
                                        const { tooltip } = context;
                                        const tooltipEl = document.getElementById('custom-tooltip');
                                    
                                        if (!tooltip.opacity) {
                                            tooltipEl.style.display = 'none';
                                            return;
                                        }
                                    
                                        const tooltipModel = tooltip;
                                        const dataIndex = tooltipModel.dataPoints[0].dataIndex;
                                        const label = labelsBar[dataIndex];
                                        const quantidade = dataBar[dataIndex];
                                    
                                        let nomes = nomesContratos[dataIndex];
                                        if (!nomes) {
                                            nomes = 'Nenhum contrato disponível';
                                        } else {
                                            let nomesArray = nomes.split('|');
                                            nomes = nomesArray.map((nome, index) => `${index + 1}. ${nome.trim()}`).join('<br>');
                                        }
                                    
                                        tooltipEl.innerHTML = `<div><strong>${label}:</strong> ${quantidade} contratos<br><strong>Contratos:</strong><br>${nomes}</div>`;
                                        tooltipEl.style.display = 'block';
                                    }
                                }
                            }
                        }
                    });

                } else {
                    console.error('Estrutura dos dados recebidos não é esperada:', responseData);
                }
            } catch (e) {
                console.error('Erro ao analisar JSON:', e);
            }
        }
    };

    xhr4.send();
}

function buscarValoresTempoContratos() {
    var xhr5 = new XMLHttpRequest();
    xhr5.open('POST', 'buscarValoresTempoContratos.php', true);

    xhr5.onreadystatechange = function () {
        if (xhr5.readyState === 4 && xhr5.status === 200) {
            try {
                let responseData = JSON.parse(xhr5.responseText);

                if (Array.isArray(responseData) && responseData.length > 0) {
                    // Inicializa os arrays para labels e valores
                    let tempos = [];
                    let valores = [];

                    // Preenche os arrays com os dados do servidor
                    responseData.forEach(item => {
                        if (item.vigenciaInicial && item.valor) {
                            tempos.push(item.vigenciaInicial);
                            valores.push(parseFloat(item.valor));
                        }
                    });

                    const ctx4 = document.getElementById('grafico4').getContext('2d');
                    new Chart(ctx4, {
                        type: 'line',
                        data: {
                            labels: tempos,
                            datasets: [{
                                label: 'Valores dos Contratos ao Longo do Tempo',
                                data: valores,
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1,
                                fill: true,
                                lineTension: 0.1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        color: 'white'
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
                                    position: 'bottom',
                                    labels: {
                                        color: 'white'
                                    }
                                },
                                title: {
                                    display: true,
                                    text: 'Valores dos Contratos ao Longo do Tempo',
                                    color: 'white'
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
        } else if (xhr5.readyState === 4) {
            console.error('Erro na requisição:', xhr5.status, xhr5.statusText);
        }
    };

    xhr5.send();
}
