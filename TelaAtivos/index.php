<?php
    include('../db/protect2.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visão Geral de Contratos</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-DP1Kb8wQuVP+44iCJcJ3rJYweuXMMA/+ttTFeZ/2ZMHgNWj5fFbRh8WB3Z2ER0qV" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="search-bar">
    <input type="text" id="search-input" placeholder="Pesquisar...">
</div>

<div class="tudo"> 
    <div class="form-container">
        <div class="container" id="mostrar">
                    <!-- <p class="paragraph"><strong>Vigência</strong><span class="exemplo_txt"></span></p>

                    <p class="paragraph"><strong>Fornecedor</strong><span class="exemplo_txt"></span></p>

                    <p class="paragraph"><strong>CNPJ</strong><span class="exemplo_txt"></span></p>

                    <p class="paragraph"><strong>Sistema</strong><span class="exemplo_txt"></span></p>

                    <p class="paragraph"><strong>Info.Contratuais</strong><span class="exemplo_txt"></span></p>

                    <p class="paragraph"><strong>Valor Anual</strong><span class="exemplo_txt"></span></p>

                    <p class="paragraph" class="border"><strong>Fiscal e-Gov</strong><span class="exemplo_txt"></span></p> -->
                    
                    
                <!-- <div class="baixo">
                    <button class="btnarqui"><span class="material-symbols-outlined">inventory_2</span>Arquivar</button>
                    <button id="editarBtn" class="btnedit"><span class="material-symbols-outlined">
                        border_color
                        </span>Editar</button>
                </div>   -->
        </div>
    </div>  
</div>



<div id="modalEditar" class="modal">
    <div class="modal-content">
        <span id="closeEditar" class="close">&times;</span>
        <div class="container" id="mostrarEditar">
            <!-- <input class="titulo" placeholder="Titulo"></input>
                <div class="container3">
                    <div class="left2">
                        <div class="input-group">
                            <p class="paragraph2"><strong>InicioVigência:</strong></p>
                            <input type="text" class="exemplo_txt2" value="Exemplo">
                        </div>
                        <div class="input-group">
                            <p class="paragraph2"><strong>FimVigência:</strong></p>
                            <input type="text" class="exemplo_txt2" value="Exemplo">
                        </div>
                        <div class="input-group">
                            <p class="paragraph2"><strong>Fornecedor:</strong></p>
                            <input type="text" class="exemplo_txt2" value="Exemplo">
                        </div>
                        <div class="input-group">
                            <p class="paragraph2"><strong>Sistema:</strong></p>
                            <input type="text" class="exemplo_txt2" value="Exemplo">
                         </div>
                        <div class="input-group">
                            <p class="paragraph2"><strong>Info.Contratuais:</strong></p>
                            <input type="text" class="exemplo_txt2" value="Exemplo">
                        </div>
                        <div class="input-group">
                            <p class="paragraph2"><strong>Valor Anual:</strong></p>
                            <input type="text" class="exemplo_txt2" value="Exemplo">
                        </div>
                        <div class="input-group">
                            <p class="paragraph2"><strong>Valor Mensal:</strong></p>
                            <input type="text" class="exemplo_txt2" value="Exemplo">
                        </div>
                        <div class="input-group">
                            <p class="paragraph2"><strong>Fiscal e-Gov:</strong></p>
                            <input type="text" class="exemplo_txt2" value="Exemplo">
                        </div>
                        <div class="input-group">
                            <p class="paragraph2"><strong>Fiscal Adm:</strong></p>
                            <input type="text" class="exemplo_txt2" value="Exemplo">
                        </div>
                    </div>
                    <div class="right2">
                        <p class="paragraph3"><strong>Objeto:</strong></p>
                        <textarea class="tamanhoFonte2 " rows="6" cols="50">Lorem ipsum dolor sit amet,
                            consectetur adipiscing elit.
                            Nunc sit amet molestie lorem.
                            Phasellus vehicula semper est, eu lobortis mi scelerisque quis.
                            Curabitur nisl erat, posuere eu nibh sit amet, ultricies aliquam odio.
                            Sed fermentum mauris eget lorem dictum, quis bibendum mi mollis.
                            In hac habitasse platea dictumst.
                        </textarea>
                        <p class="paragraph3"><strong>Detalhes e Observações:</strong></p>
                        <textarea class="tamanhoFonte2 " rows="6" cols="50">Lorem ipsum dolor sit amet,
                            consectetur adipiscing elit.
                            Nunc sit amet molestie lorem.
                            Phasellus vehicula semper est, eu lobortis mi scelerisque quis.
                            Curabitur nisl erat, posuere eu nibh sit amet, ultricies aliquam odio.
                            Sed fermentum mauris eget lorem dictum, quis bibendum mi mollis.
                            In hac habitasse platea dictumst.
                        </textarea>
                    </div>
                </div>
                <div class="bottom2">
                    <div class="bottom-left2">
                        <p class="tituloInput"><strong>Gestores:</strong></p>
                        <input type="text" class="inputBottom">
                    </div>
                    <div class="bottom-right2">
                        <p class="tituloInput"><strong>Secretaria:</strong></p>
                        <input type="text" class="ex_borda3">
                    </div>
                </div>
                <div class="form-group2">
                    <span class="doc_contrato2"2><strong>Doc.Contrato</strong></span>
                    <button type="submit3" class="btn_anexo2">Anexe Aqui</button>
                </div>
                <div class="bottom2">
                    <div class="bottom-left2">
                        <p class="tituloInput"><strong>Categoria:</strong></p>
                        <input type="text" class="inputBottom">
                    </div>
                    <div class="bottom-right2">
                        <p class="tituloInput"><strong>Nome_Comercial:</strong></p>
                        <input type="text" class="ex_borda3">
                    </div> 
                </div>
    
                <div class="row justify-content-between">
    
                    <div class="salvar">
                        <button type="buttonB" onclick="salvar()" class="btn btn-custom btn-lg">Salvar</button>
                    </div>     
                </div>
                        -->
      
        </div>
    </div>
</div>

<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <a href="#" onclick="toggleSidebar()">☰</a><img src="../imagens/icondash.jpg" class="icondash" style="width: 50%;">
    </div>
    <a href="../TelaDashboard/#" class="icon-middle"><span class="material-symbols-outlined">grid_view</span><span class="icon-text"> Dashboard</span></a>

    <a href="../TelaCadastros/#" class="icon-middle"><span class="material-symbols-outlined">how_to_reg</span><span class="icon-text"> Cadastro</span></a>

    <a href="../CadastroContratos/#" class="icon-middle"><span class="material-symbols-outlined">add</span><span class="icon-text" >Adicionar</span></a>

    <a href="#" class="icon-middle"><span class="material-symbols-outlined">contract</span></i><span class="icon-text"> Contratos</span></a>

    <a href="../TelaArquivados/#" class="icon-middle"><span class="material-symbols-outlined">inventory_2</span><span class="icon-text"> Arquivados</span></a>

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

<script src="script.js"></script>  
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>


<script>
    function addModalEventListeners() {
        var editarBtn = document.getElementById('editarBtn');
        var modalEditar = document.getElementById('modalEditar');
        var closeEditar = document.getElementById('closeEditar');

        // Função para abrir o modal de edição
        editarBtn.addEventListener('click', function() {
            modalEditar.style.display = 'block';
        });

        // Função para fechar o modal de edição
        closeEditar.addEventListener('click', function() {
            modalEditar.style.display = 'none';
        });

        // Função para fechar o modal quando clicar fora dele
        // window.addEventListener('click', function(event) {
        //     if (event.target == modalEditar) {
        //         modalEditar.style.display = 'none';
        //     }
        // });
    }
    
    function trocarDisplay( value ){

        // Configure a chamada AJAX
        var formData = new FormData();

        formData.append('codigo',value);

        xhr3 = new XMLHttpRequest();

        xhr3.open('POST', 'buscarDados.php', true);

        xhr3.onreadystatechange = function () {

            if (xhr3.readyState === 4 && xhr3.status === 200){                       
                
                let string    = xhr3.responseText;               
                // alert( string );
                document.getElementById('mostrar').innerHTML = string;
                addModalEventListeners();
        }

        }
        xhr3.send(formData); 
    }

    function fetchSupervisores() {
        $.ajax({
            url: '../CadastroContratos/fetch_supervisores.php', 
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                // Cria uma lista com os nomes dos supervisores
                var supervisorNames = data.map(function (supervisor) {
                    return supervisor.nomeSupervisor; 
                });

                // Configura o autocomplete para os campos de supResponsavel[] no modal
                setupAutocomplete('input[name="supResponsavel[]"]', supervisorNames);
            },
            error: function (error) {
                console.error('Erro ao buscar dados:', error);
            }
        });
    }

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
        
    function trocarDisplayModal(value) {
        // Configure a chamada AJAX
        var formData = new FormData();
        formData.append('codigo', value);

        xhr3 = new XMLHttpRequest();
        xhr3.open('POST', 'buscarDadosEditar.php', true);

        xhr3.onreadystatechange = function () {
            if (xhr3.readyState === 4 && xhr3.status === 200) {     
                let string = xhr3.responseText;               
                document.getElementById('mostrarEditar').innerHTML = string;
                
                // Adiciona os eventos de blur e autocomplete após o modal ser carregado
                adicionarEventosBlurAutocomplete();
                
                // Configura o input de arquivos
                setupFileInput('documentos', 'fileList');
            }
        }
        xhr3.send(formData); 
    }

    function adicionarEventosBlurAutocomplete() {
        const singleValueFields = ['supResponsavel'];

        // Verificar supervisores (fetch via AJAX)
        fetchSupervisores();

        // Associar evento blur a todos os campos 'supResponsavel[]'
        singleValueFields.forEach(name => {
            const inputs = document.querySelectorAll(`input[name="${name}"], input[name="${name}[]"]`);
            inputs.forEach(input => {
                input.addEventListener("blur", () => handleBlur(input, name));
            });
        });
    }

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

    const verifyField = async (name, value) => {
        console.log(`Verifying field: ${name}, Value: ${value}`);
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
            return { value, exists: data.exists };
        } catch (error) {
            console.error('Error:', error);
            return { value, exists: false };
        }
    };


    function fetchContratosAtivos() {
        fetch('fetch_data.php')
        .then(response => response.json())
        .then(data => {
            const container = document.querySelector('.tudo');
            data.forEach(contract => {
                const contractDiv = `
                    <button class="contratos ${contract.classificacaoContrato} ${contract.fornecedor} ${contract.infoContratuais}" onclick="trocarDisplay(${contract.idContrato});">${contract.nomeUsual}</button>
                `;
                container.innerHTML += contractDiv;
            });
        })
        .catch(error => console.error('Erro ao buscar dados:', error));
    }

    // chama as funções qnd carregar a página
    document.addEventListener('DOMContentLoaded', function() {
        fetchContratosAtivos();
    });

    function arquivarContrato(idContrato) {
        Swal.fire({
            title: 'Tem certeza?',
            text: "Você está prestes a arquivar este contrato!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, arquivar!'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('arquivado.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `idContrato=${idContrato}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire(
                            'Arquivado!',
                            data.message,
                            'success'
                        ).then(() => {
                            location.reload(); 
                        });
                    } else {
                        Swal.fire('Erro', data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    Swal.fire('Erro', 'Erro ao arquivar contrato.', 'error');
                });
            }
        });
    }



    document.getElementById('search-input').addEventListener('input', function() {
            const searchValue = this.value.toUpperCase();
            const buttons = document.querySelectorAll('.tudo .contratos');
            
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

    function setupFileInput(inputId, listId) {
        const fileInput = document.getElementById(inputId);
        const fileList = document.getElementById(listId);

        fileInput.addEventListener('change', (event) => {
            fileList.innerHTML = '';

            const files = event.target.files;

            if (files.length > 0) {
                const ul = document.createElement('ul');

                for (let i = 0; i < files.length; i++) {
                    const li = document.createElement('li');
                    li.textContent = files[i].name;
                    ul.appendChild(li);
                }

                fileList.appendChild(ul);
            } else {
                fileList.textContent = 'Nenhum arquivo selecionado.';
            }
        });
    }

    let numeroDeLinhasSupervisores = 0;

    function adicionarSupervisores() {
        if (!verificarVetores("supResponsavel")) {
            alert('Informe o responsável pelo supervisor!');
            document.getElementById("supResponsavel").focus();
        } else if (!verificarVetores("supStatus")) {
            alert('Informe o status do supervisor!');
            document.getElementById("supStatus").focus();
        } else {
            const tabela = document.getElementById("tabelaSupervisores");

            // Criar uma nova linha
            const novaLinha = tabela.insertRow();
            novaLinha.classList.add("tabelaSupervisoresGap", "mediaColuna");

            const colunaResponsavel = novaLinha.insertCell(0);
            const colunaStatus = novaLinha.insertCell(1);
            const colunaAcao = novaLinha.insertCell(2);

            colunaResponsavel.innerHTML = "<input type='text' name='supResponsavel[]' class='form-control supResponsavel' placeholder='Responsável'>";
            colunaStatus.innerHTML = "<select class='form-control' name='supStatus[]' id='supStatus'><option selected disabled>Tipo</option><option value='Fiscal-Egov'>Fiscal-Egov</option><option value='Fiscal'>Fiscal</option><option value='Gestor'>Gestor</option></select>";

            // Adicionar primeiro o botão de remover e depois o botão de adicionar
            colunaAcao.innerHTML = "<input type='button' class='btn btn-success btn-sm' onclick='adicionarSupervisores()' value='+'> <input type='button' class='btn btn-danger btn-sm' onclick='excluirLinhaSupervisores(this)' value='-'> ";

            // Reassociar as funcionalidades de blur e autocomplete
            reassociarEventosBlurAutocomplete();

            // Atualizar as ações da última linha
            if (numeroDeLinhasSupervisores > 0) {
                let ultimaLinha = tabela.rows[numeroDeLinhasSupervisores - 1];
                let ultimaColunaAcao = ultimaLinha.cells[2];
                ultimaColunaAcao.innerHTML = "<input type='button' class='btn btn-success btn-sm' onclick='adicionarSupervisores()' value='+'> <input type='button' class='btn btn-danger btn-sm' onclick='excluirLinhaSupervisores(this)' value='-'>";
            }

            numeroDeLinhasSupervisores++;
        }
    }

    function excluirLinhaSupervisores(botao) {
        const tabela = document.getElementById("tabelaSupervisores");
        const linha = botao.parentNode.parentNode;
        linha.parentNode.removeChild(linha);
        numeroDeLinhasSupervisores--;

        // Se ainda houver linhas, atualizar a última linha para incluir os botões
        if (numeroDeLinhasSupervisores > 0) {
            let ultimaLinha = tabela.rows[numeroDeLinhasSupervisores - 1];
            let ultimaColunaAcao = ultimaLinha.cells[2];
            ultimaColunaAcao.innerHTML = "<input type='button' class='btn btn-success btn-sm' onclick='adicionarSupervisores()' value='+'> <input type='button' class='btn btn-danger btn-sm' onclick='excluirLinhaSupervisores(this)' value='-'>";
        }
    }

    function salvarAta() {
        // Supervisores
        if (!verificarVetores("supResponsavel")) {
            alert('Informe o responsável pelo supervisor!');
            document.getElementById("supResponsavel").focus();
        }
        else if (!verificarVetores("supStatus")) {
            alert('Informe o status do supervisor!');
            document.getElementById("supStatus").focus();
        }
        else {
            // Salvando o formulário
            var formData = new FormData();

            for (var i = 0; i < document.getElementsByName('supResponsavel[]').length; i++) {
                formData.append('supResponsavel[]', document.getElementsByName('supResponsavel[]')[i].value);
            }
            for (var i = 0; i < document.getElementsByName('supStatus[]').length; i++) {
                formData.append('supStatus[]', document.getElementsByName('supStatus[]')[i].value);
            }

            // Configure a chamada AJAX
            xhr3 = new XMLHttpRequest();

            xhr3.open('POST', 'teste.php', true);

            xhr3.onreadystatechange = function () {
                if (xhr3.readyState === 4 && xhr3.status === 200) {                       
                    let string = JSON.parse(xhr3.responseText);
                    
                    if (string.valor !== 0) {
                        document.getElementById('ataCodigo').value = string.valor;
                    } else { 
                        console.log(string); 
                    }
                    
                    alert(string.msg);
                }
            }
            xhr3.send(formData); 
        }
        limparCampos();
    }

    function verificarVetores(vetor) {
        var ok = true;

        switch (vetor) {
            case 'supResponsavel':
                for (var i = 0; i < document.getElementsByName('supResponsavel[]').length; i++) {
                    if (document.getElementsByName('supResponsavel[]')[i].value == '') ok = false;
                }
                break
            case 'supStatus':
                for (var i = 0; i < document.getElementsByName('supStatus[]').length; i++) {
                    if (document.getElementsByName('supStatus[]')[i].value == 'Tipo') ok = false;
                }
                break
        }

        return ok;    
    }

    function limparCampos() {
        // Limpar todos os campos de responsáveis
        let responsaveis = document.getElementsByName('supResponsavel[]');
        for (let i = 0; i < responsaveis.length; i++) {
            responsaveis[i].value = "";
        }

        // Limpar todos os campos de status
        let statusCampos = document.getElementsByName('supStatus[]');
        for (let i = 0; i < statusCampos.length; i++) {
            statusCampos[i].value = "Tipo";
        }
    }

    function reassociarEventosBlurAutocomplete() {
        // Reassociar o evento 'blur' para todos os inputs de 'supResponsavel[]'
        document.querySelectorAll('input[name="supResponsavel[]"]').forEach(input => {
            input.addEventListener('blur', function() {
                handleBlur(input, 'supResponsavel'); // Certifique-se de que handleBlur está definido corretamente
            });
        });

        // Reaplicar o autocomplete aos novos inputs
        fetchSupervisores(); // Certifique-se de que fetchSupervisores está carregando a lista de supervisores corretamente
    }

    function aditivarJS(value) {
        Swal.fire({
            title: 'Confirmar Aditivo',
            text: "Deseja realmente aditivar este contrato?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, aditivar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                var formData = new FormData();
                formData.append('codigo', value);

                var xhr4 = new XMLHttpRequest();
                xhr4.open('POST', 'aditivar.php', true);

                xhr4.onload = function () {
                    if (xhr4.status === 200) {
                        console.log("Resposta do servidor:", xhr4.responseText); // Log para depuração
                        try {
                            var response = JSON.parse(xhr4.responseText);

                            if (response.error) {
                                Swal.fire({
                                    title: 'Erro!',
                                    text: response.error,
                                    icon: 'error'
                                });
                            } else if (response.success) {
                                Swal.fire({
                                    title: 'Sucesso!',
                                    text: response.message || 'Operação concluída com sucesso!',
                                    icon: 'success'
                                }).then(() => {
                                    window.location.reload(); // Atualiza a página após o sucesso
                                });
                            } else {
                                Swal.fire({
                                    title: 'Erro!',
                                    text: 'Resposta inesperada do servidor.',
                                    icon: 'error'
                                });
                            }
                        } catch (e) {
                            console.error("Erro ao interpretar JSON:", e);
                            Swal.fire({
                                title: 'Erro!',
                                text: 'Erro ao processar a resposta do servidor.',
                                icon: 'error'
                            });
                        }
                    } else {
                        Swal.fire({
                            title: 'Erro!',
                            text: 'Erro ao fazer a requisição. Código: ' + xhr4.status,
                            icon: 'error'
                        });
                    }
                };

                xhr4.onerror = function () {
                    Swal.fire({
                        title: 'Erro!',
                        text: 'Erro de conexão ao tentar enviar os dados.',
                        icon: 'error'
                    });
                };

                xhr4.send(formData);
            }
        });
    }








</script>

</body>
</html>

  