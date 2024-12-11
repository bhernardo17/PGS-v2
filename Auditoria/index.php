<?php
    include('../db/protect3.php');
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Fontes -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@600&display=swap" rel="stylesheet"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@600&family=Montserrat:wght@606&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <!-- Icones -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <title>registro de auditoria</title>

    <style>
        .buttonRel {
            background: rgba(148, 168, 207, 1);
            color: rgb(255, 255, 255);
            border: none;
            cursor: pointer;
            display: flex; 
            margin: 1% auto; 
            /* margin-top: 3%; */
            border-radius: 5px;
            /* max-width: 500vw; */
            width: 50%;
            justify-content: space-between;
        }
       
    </style>
</head>
<body>
\

<div class="filter-container">
    <label for="start-date">Data Inicial:</label>
    <input type="date" id="start-date">

    <label for="end-date">Data Final:</label>
    <input type="date" id="end-date">

    <button id="filter-button">Filtrar</button>
    <!-- <button id="openModalBtn">Gerar Relatório</button> -->
    
 </div>

<div class="search-bar">
    <input type="text" id="search-input" placeholder="Pesquisar...">
</div>

    <!-- <div class="filter-container">
        <label for="start-date">Data Inicial:</label>
        <input type="date" id="start-date">

        <label for="end-date">Data Final:</label>
        <input type="date" id="end-date">
    </div> -->
    <!-- <button id="btnHistorico">Limpar Histórico<i class="bi bi-trash" id="trash"></i></button> -->
<div class="fora">
    



</div>


 
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <a href="#" onclick="toggleSidebar()">☰</a><img src="../imagens/icondash.jpg" class="icondash" style="width: 50%;">
    </div>
    <a href="../TelaDashboard/#" class="icon-middle"><span class="material-symbols-outlined">grid_view</span><span class="icon-text"> Dashboard</span></a>
    
    <a href="../TelaCadastros/#" class="icon-middle"><span class="material-symbols-outlined">how_to_reg</span><span class="icon-text"> Cadastro</span></a>
    
    <a href="../CadastroContratos/#" class="icon-middle"><span class="material-symbols-outlined">add</span><span class="icon-text" >Adicionar</span></a>
    
    <a href="../TelaAtivos/#" class="icon-middle"><span class="material-symbols-outlined">contract</span></i><span class="icon-text"> Contratos</span></a>
    
    <a href="../TelaArquivados/#" class="icon-middle"><span class="material-symbols-outlined">inventory_2</span><span class="icon-text"> Arquivados</span></a>
    
    <a href="../relatorio/#" class="icon-middle"><span class="material-symbols-outlined">summarize</span><span class="icon-text">Relatório </span></a>
        

    <div class="bottom-icons">
        <a href="#" class="icon-bottom"><span class="material-symbols-outlined">update</span><span class="icon-text"> Auditoria</span></a>
    
        <a href="../db/logout.php" onclick="return confirmLogout();" class="icon-text">
            <i class="fa fa-sign-out"></i><span class="material-symbols-outlined">logout</span>
        </a>
    </div>
</div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            fetchContratos();
        });        

        function confirmLogout() {
            if (confirm('Tem certeza que deseja sair?')) {
                return true; // Prossiga com o logout
            } else {
                return false; // Cancela o logout
            }
        }

        function fetchContratos() {
            fetch('fetch_data.php')
            .then(response => response.json())
            .then(data => {
                const container = document.querySelector('.fora');
                data.forEach(interacao => {
                    const contractDiv = `
                        <div class="boxAuditoria" data-date="${interacao.horaAuditoria}">
                            <div class="infoAuditoria"><i class="bi bi-clock ${interacao.usuario} ${interacao.tipoInteracao} ${interacao.nomeDoAlvo}"  id="clock">
                            </i>${interacao.usuario}, ${interacao.tipoInteracao}: ${interacao.nomeDoAlvo} #${interacao.idInteracao}</div>
                            <div class="timeAuditoria"><p>${interacao.horaAuditoria}</p></div>
                        </div>
                    `;
                    container.innerHTML += contractDiv;
                    });
                })
                .catch(error => console.error('Erro ao buscar dados:', error));
        }

        document.getElementById('search-input').addEventListener('input', function() {
            const searchValue = this.value.toUpperCase();
            const buttons = document.querySelectorAll('.fora .boxAuditoria');
            
            buttons.forEach(button => {
                const buttonText = button.textContent || button.innerText;
                const buttonClass = button.className.toUpperCase();
                
                if (buttonText.toUpperCase().indexOf(searchValue) > -1 || buttonClass.indexOf(searchValue) > -1) {
                    button.style.display = '';
                } else {
                    button.style.display = 'none';
                }
            });
        });

        document.getElementById('filter-button').addEventListener('click', function () {
            const startDate = new Date(document.getElementById('start-date').value);
            const endDate = new Date(document.getElementById('end-date').value);

            endDate.setDate(endDate.getDate() + 1);

            if (isNaN(startDate) || isNaN(endDate)) {
                alert("Por favor, insira datas válidas.");
                return;
            }

            const boxes = document.querySelectorAll('.boxAuditoria');

            boxes.forEach(box => {
                const boxDateStr = box.getAttribute('data-date');
                const boxDate = parseDate(boxDateStr);


                if (boxDate >= startDate && boxDate < endDate) {
                    box.style.display = '';
                } else {
                    box.style.display = 'none';
                }
            });
        });

        function parseDate(dateStr) {
            // Formato esperado: DD-MM-YYYY HH:MM:SS
            const [datePart, timePart] = dateStr.split(' ');
            const [day, month, year] = datePart.split('-').map(Number);
            const [hours, minutes, seconds] = timePart.split(':').map(Number);
            
            return new Date(year, month - 1, day, hours, minutes, seconds);
        }

        // window.onload = function() {
        //     const startDateInput = document.getElementById('start-date');
        //     const endDateInput = document.getElementById('end-date');

        //     if (startDateInput && endDateInput) {
        //         startDateInput.addEventListener('change', filterByDate);
        //         endDateInput.addEventListener('change', filterByDate);
        //     }

        //     function filterByDate() {
        //         const startDateValue = startDateInput.value.split('-').reverse().join('-');
        //         const endDateValue = endDateInput.value.split('-').reverse().join('-');
        //         const startDate = new Date(startDateValue);
        //         const endDate = new Date(endDateValue);
        //         const buttons = document.querySelectorAll('.fora .boxAuditoria');

        //         buttons.forEach(button => {
        //             const rawDate = button.getAttribute('data-date')?.split(' ')[0]; // Extrai a parte "DD-MM-YYYY"
        //             if (!rawDate) return; // Se rawDate for null, pula para o próximo elemento
        //             const formattedDate = new Date(rawDate.split('-').reverse().join('-')); // Converte para "YYYY-MM-DD"

        //             if ((isNaN(startDate.getTime()) || formattedDate >= startDate) &&
        //                 (isNaN(endDate.getTime()) || formattedDate <= endDate)) {
        //                 button.style.display = '';
        //             } else {
        //                 button.style.display = 'none';
        //             }
        //         });
        //     }
        // };

       
    </script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>
</body>
</html>