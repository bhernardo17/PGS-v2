<?php
    include('../db/protect1.php'); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Contrato</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="style.css">
    <style>
        .input-container input.error {
            border: 2px solid red;
        }

    </style>
</head>
<body>

<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <a href="#" onclick="toggleSidebar()">☰</a><img src="../imagens/icondash.jpg" class="icondash" style="width: 50%;">
    </div>
    <a href="../TelaDashboard/#" class="icon-middle"><span class="material-symbols-outlined">grid_view</span><span class="icon-text"> Dashboard</span></a>

    <a href="../TelaCadastros/#" class="icon-middle"><span class="material-symbols-outlined">how_to_reg</span><span class="icon-text"> Cadastro</span></a>

    <a href="#" class="icon-middle"><span class="material-symbols-outlined">add</span><span class="icon-text" >Adicionar</span></a>

    <a href="../TelaAtivos/#" class="icon-middle"><span class="material-symbols-outlined">contract</span></i><span class="icon-text"> Contratos</span></a>

    <a href="../TelaArquivados/#" class="icon-middle"><span class="material-symbols-outlined">inventory_2</span><span class="icon-text"> Arquivados</span></a>

    <a href="../PermissaoUsuario/" class="icon-middle"><span class="material-symbols-outlined">groups</span><span class="icon-text"> Usuários</span></a>

    <a href="../relatorio/#" class="icon-middle"><span class="material-symbols-outlined">summarize</span><span class="icon-text">Relatório </span></a>
        

    <div class="bottom-icons">
        <a href="../Auditoria/" class="icon-bottom"><span class="material-symbols-outlined">update</span><span class="icon-text"> Auditoria</span></a>

        <a href="../db/logout.php" onclick="return confirmLogout();" class="icon-text">
          <i class="fa fa-sign-out"></i><span class="material-symbols-outlined">logout</span>
        </a>
    </div>
</div>
    
<script>
    function confirmLogout() {
        if (confirm('Tem certeza que deseja sair?')) {
            return true; // Prossiga com o logout
        } else {
            return false; // Cancela o logout
        }
    }
</script>
<form action="envionew.php" method="POST" enctype="multipart/form-data">
    <div class="container">
        <h2>Sistema</h2>

    <div class="topo_form"><!-- Nome Comercial -->
        <div class="input-group">
            <label for="nomeComercial">Nome Comercial</label>
            <input type="text" name="nomeComercial" id="nomeComercial" required>
        </div>
        <div class="input-group">
                <label for="vigenciaInicial">Vigência Inicial</label>
                <input type="date" name="vigenciaInicial" class="rounded" required>
            </div>
            <div class="input-group">
                <label for="vigenciaFinal">Vigência Final</label>
                <input type="date" name="vigenciaFinal" class="rounded" required>
            </div>
    </div>
        <!-- Vigências -->
        <div class="vigencias_pos">
    </div>       
    

        <div class="lados">
            <div class="left">
                <div class="input-container">
                    <label for="fornecedorInput">Fornecedor</label>
                    <input type="text" id="fornecedorInput" name="fornecedor" class="rounded" placeholder="Fornecedor:" required>
                </div>
                <div class="input-container">
                    <label for="nomeUsual">Nome Usual</label>
                    <input type="text" name="nomeUsual" class="rounded" placeholder="Nome Usual" required>
                </div>
                <div class="input-container">
                    <label for="infoContratuais">Informações Contratuais</label>
                    <input type="text" name="infoContratuais" class="rounded" placeholder="Ex: 1075/SMA/2022" required>
                </div>
                <div class="input-container">
                    <label for="custoAnual">Custo Anual</label>
                    <input type="text" name="custoAnual" class="rounded" placeholder="Ex: 10000,00" required>
                </div>
                <div class="input-container">
                    <label for="custoMensal">Custo Mensal</label>
                    <input type="text" name="custoMensal" class="rounded" placeholder="Ex: 10000,00" required>
                </div>
                <div class="input-container">
                    <label for="dotacao">Dotação Orçamentária</label>
                    <input type="text" name="dotacao" class="rounded" placeholder="Dotação Orçamentária:" required>
                </div>
                <div class="input-container">
                    <label for="admSuporte">Administrador do Sistema</label>
                    <input type="text" name="admSuporte" class="rounded" placeholder="Administrador do Sistema:">
                </div>

                <!-- Pendências -->
                
            </div>

            <!-- Sessão de Alinhamento Direito -->
            <div class="right">
                <div class="input-group">
                    <label for="objeto">Objeto</label>
                    <textarea name="objetoContrato" id="objeto" class="textarea-custom rounded" placeholder="Descreva o objeto do contrato"></textarea>
                </div>
                <div class="input-group">
                    <label for="observacoes">Detalhes e Observações</label>
                    <textarea name="observacaoContrato" class="textarea-custom rounded" id="observacoes" placeholder="Adicione observações ou detalhes"></textarea>
                </div>
                <div class="input-group">
                    <label for="links">Link Externo</label>
                    <textarea name="objetoContrato" class="textarea-custom rounded" id="links" placeholder="Insira o link externo"></textarea>
                </div>
                <div class="input-group">
                    <label for="categoria">Categoria</label>
                    <input type="text" name="categoria" id="categoria" required>
                </div>
                <div class="input-group">
                    <label for="secretaria">Secretaria</label>
                    <input type="text" name="secretaria" placeholder="Divida as Secretarias com vírgulas" class="rounded" required>
                </div>
                <div class="supervisores-section">
                    
                    <table name="tabelaSupervisores" id="tabelaSupervisores">
                        <tr>
                        <p>Fiscal/Gestor</p>
                            <td>
                                <input type="text" id="supResponsavel" name="supResponsavel[]" class="form-control supResponsavel" placeholder="Responsável">
                            </td>
                            <td>
                                <select name="supStatus[]" id="supStatus" class="form-control">
                                    <option disabled selected>Tipo</option>
                                    <option value="Fiscal-Egov">Fiscal-Egov</option>
                                    <option value="Fiscal">Fiscal</option>
                                    <option value="Gestor">Gestor</option>
                                </select>
                            </td>
                            <td>
                                <input type="button" class="btn btn-success btn-sm" id="btnAddSup" onclick="adicionarSupervisores();" value="+">
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            

        </div>
        <div class="clearfix"></div>

<!-- Categoria e Secretaria -->
    <div class="form-section center">
        
    </div>

    <!-- Documentos -->
    <div class="btn_adc_contrato">
        <p>Documentos do Contrato</p>
        <label for="documentos" class="file-upload-label btn btn-primary">Anexe aqui</label>
        <input type="file" name="documentos[]" id="documentos" multiple class="form-control visually-hidden">
        <div id="fileList"></div>
    </div>

    <!-- Botões de Salvar e Cancelar -->
    <div class="rodape_btn mt-3">
        <input type="button" value="Cancelar" onclick="cancelar()" class="btn_cancelar">
        <input type="submit" value="Salvar" class="btn_salvar">
    </div>
            <!-- Sessão de Alinhamento Esquerdo -->
            
        </div>
</form>





    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const singleValueFields = ['fornecedor', 'supResponsavel', 'secretaria'];

            // Associando evento blur a todos os campos 'fornecedor' e 'supResponsavel[]'
            singleValueFields.forEach(name => {
                const inputs = document.querySelectorAll(`input[name="${name}"], input[name="${name}[]"]`);
                inputs.forEach(input => {
                    input.addEventListener("blur", () => handleBlur(input, name));
                });
            });


        });

        // document.addEventListener("DOMContentLoaded", () => {
        //     const fileInput = document.getElementById('documentos');
        //     const fileList = document.getElementById('fileList');

        //     fileInput.addEventListener('change', (event) => {
        //         fileList.innerHTML = '';

        //         const files = event.target.files;

        //         if (files.length > 0) {
        //             const ul = document.createElement('ul');

        //             for (let i = 0; i < files.length; i++) {
        //                 const li = document.createElement('li');
        //                 li.textContent = files[i].name;
        //                 ul.appendChild(li);
        //             }

        //             fileList.appendChild(ul);
        //         } else {
        //             fileList.textContent = 'Nenhum arquivo selecionado.';
        //         }
        //     });
        // });

        $(document).ready(function () {
            fetchSupervisores(); 
        });

        function fetchSupervisores() {
            $.ajax({
                url: 'fetch_supervisores.php', 
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    // Cria uma lista com os nomes dos supervisores
                    var supervisorNames = data.map(function (supervisor) {
                        return supervisor.nomeSupervisor; 
                    });

                    // Configura o autocomplete para o input de responsável
                    setupAutocomplete('input[name="supResponsavel[]"]', supervisorNames);

                },
                error: function (error) {
                    console.error('Erro ao buscar dados:', error);
                }
            });
        }

        const verifyField = async (name, value) => {
                console.log(`Verifying field: ${name}, Value: ${value}`); // Verifica o nome e valor enviados
                if (value === '') return { value, exists: true };

                try {
                    const response = await fetch('../db/verificar_input.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `name=${encodeURIComponent(name)}&value=${encodeURIComponent(value)}`
                    });

                    const data = await response.json();
                    console.log(data); // Verifica a resposta do back-end
                    return { value, exists: data.exists };
                } catch (error) {
                    console.error('Error:', error);
                    return { value, exists: false };
            }
        };

        const handleBlur = async (input, name) => {
            const values = input.value.toUpperCase().split(',').map(value => value.trim());
            const promises = values.map(value => verifyField(name, value));
            const results = await Promise.all(promises);

            let hasError = false;
            results.forEach(result => {
                if (!result.exists) {
                    hasError = true;
                }
            });

            if (hasError) {
                input.classList.add('error');
                input.style.borderColor = 'red';
            } else {
                input.classList.remove('error');
                input.style.borderColor = '';
            }
        };

        function setupAutocomplete(inputSelector, sourceData) {
            $(inputSelector).autocomplete({
                source: function (request, response) {
                    var terms = request.term.split(/,\s*/);
                    var lastTerm = terms.pop(); 

                    response($.ui.autocomplete.filter(sourceData, lastTerm)); 
                },
                focus: function () {
                    return false; 
                },
                select: function (event, ui) {
                    var terms = this.value.split(/,\s*/); 
                    terms.pop(); 
                    terms.push(ui.item.value);  
                    this.value = terms; 


                    moveCursorToEnd(this);

                    return false;
                }
            });
        }

        function moveCursorToEnd(el) {
            setTimeout(function() {
                el.focus(); 
                el.setSelectionRange(el.value.length, el.value.length); 
            }, 0);
        }

        $(document).ready(function () {
            fetchFornecedores(); // Carrega a lista de fornecedores e configura o autocomplete
        });

        function fetchFornecedores() {
            $.ajax({
                url: 'fetch_fornecedores.php', // URL para buscar os dados de fornecedores
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    var fornecedorNames = data.map(function (fornecedor) {
                        return fornecedor.nomeFornecedor; // Mapeia apenas os nomes dos fornecedores
                    });

                    // Configura o autocomplete para o input de fornecedor
                    $('#fornecedorInput').autocomplete({
                        source: fornecedorNames,
                        focus: function () {
                            return false; // Impede que o autocomplete sobrescreva o valor
                        },
                        select: function (event, ui) {
                            this.value = ui.item.value; // Define o valor selecionado
                            return false; // Impede a ação padrão do select
                        }
                    });
                },
                error: function (error) {
                    console.error('Erro ao buscar dados:', error);
                }
            });
        }



    // Tabela Supervisores
    let numeroDeLinhasSupervisores = 0;

    function adicionarSupervisores() {
        if (!verificarVetores("supResponsavel")) {
            const ultimosupResponsavel = document.querySelector(".supResponsavel:last-child");
            ultimosupResponsavel.focus(); // Dá o foco ao último input adicionado
        } else if (!verificarVetores("supStatus")) {
            document.getElementById("supStatus").focus();
        } else {
            const tabela = document.getElementById("tabelaSupervisores");
            const novaLinha = tabela.insertRow();

            novaLinha.classList.add("tabelaSupervisoresGap", "mediaColuna");

            const colunaResponsavel = novaLinha.insertCell(0);
            const colunaStatus = novaLinha.insertCell(1);
            const colunaAcao = novaLinha.insertCell(2);

            colunaResponsavel.innerHTML = "<input type='text' name='supResponsavel[]' class='form-control supResponsavel' placeholder='Responsável'>";
            colunaStatus.innerHTML = "<select class='form-control' name='supStatus[]' id='supStatus'><option selected disabled>Tipo</option><option value='Fiscal-Egov'>Fiscal-Egov</option><option value='Fiscal'>Fiscal</option><option value='Gestor'>Gestor</option></select>";
            colunaAcao.innerHTML = "<input type='button' class='btn btn-success btn-sm' onclick='adicionarSupervisores()' value='+'> <input type='button' class='btn btn-danger btn-sm' onclick='excluirLinhaSupervisores(this)' value='-'>";

            // Reassociar o evento 'blur' ao novo campo de 'supResponsavel[]'
            const novosInputs = novaLinha.querySelectorAll('input[name="supResponsavel[]"]');
            novosInputs.forEach(input => {
                input.addEventListener("blur", () => handleBlur(input, 'supResponsavel'));
            });

            // Aplicar o autocomplete ao novo campo de 'supResponsavel[]'
            fetchSupervisores(); // Certifica-se de que os supervisores sejam carregados e o autocomplete aplicado
        }
    }


    function excluirLinhaSupervisores(botao) {
        const linha = botao.parentNode.parentNode;
        linha.parentNode.removeChild(linha);
        numeroDeLinhasSupervisores--;
    }

    document.getElementById('contratoForm').addEventListener('submit', function(event) {
        // Array com os campos obrigatórios
        const requiredFields = [
            'nomeComercial', 
            'vigenciaInicial', 
            'vigenciaFinal', 
            'fornecedor', 
            'nomeUsual', 
            'infoContratuais', 
            'custoAnual', 
            'custoMensal', 
            'dotacao', 
            'categoria', 
            'secretaria'
        ];

        let allFilled = true; // Flag para verificar se todos os campos estão preenchidos
        let missingFields = []; // Array para armazenar os campos que estão faltando

        // Verifica cada campo obrigatório
        requiredFields.forEach(field => {
            const input = document.querySelector(`input[name="${field}"], textarea[name="${field}"]`);
            if (input && !input.value.trim()) {
                allFilled = false; // Um campo obrigatório não está preenchido
                missingFields.push(field); // Adiciona o campo à lista
                input.classList.add('error'); // Adiciona uma classe de erro para destacar
            } else {
                input.classList.remove('error'); // Remove a classe de erro se o campo estiver preenchido
            }
        });

        // Se algum campo obrigatório não estiver preenchido
        if (!allFilled) {
            event.preventDefault(); // Impede o envio do formulário
            alert(`Por favor, preencha os seguintes campos: ${missingFields.join(', ')}`); // Exibe um alerta com os campos que faltam
        }
    });

    </script>    
    <script src="script.js"></script>
</body>
</html>