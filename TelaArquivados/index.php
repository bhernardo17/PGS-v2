<?php
    include('../db/protect1.php');
?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arquivados</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-DP1Kb8wQuVP+44iCJcJ3rJYweuXMMA/+ttTFeZ/2ZMHgNWj5fFbRh8WB3Z2ER0qV" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="style.css">
    <style>
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
<div class="search-bar" >
    <input id="search-input" type="text" placeholder="Pesquisar...">
</div> 
    <div class="tudo">
        <div class="form-group">
            <div class="dropdown-content" id="mostrar">
                <!-- <div class="dropdown-content" id="dropdownContent">
                    <form class="form-container">
                        <div class="container">
                            <button id="editarBtn" class="btnedit"><span class="material-symbols-outlined">
                        border_color
                        </span>Editar</button>
                            <h1>Titulo</h1>
                        </div>
                        <div class="container2">
                            <div class="left">
                                <p class="paragraph"><strong>Inicio da vigência: </strong><span class="exemplo_txt">Exemplo</span></p>
                                <p class="paragraph"><strong>Fim da Vigência:</strong><span class="exemplo_txt">Exemplo</span></p>
                                <p class="paragraph"><strong>Fornecedor:</strong><span class="exemplo_txt">Exemplo</span></p>
                                <p class="paragraph"><strong>CNPJ:</strong><span class="exemplo_txt">Exemplo</span></p>
                                <p class="paragraph"><strong>Sistema:</strong><span class="exemplo_txt">Exemplo</span></p>
                                <p class="paragraph"><strong>Info.Contratuais:</strong><span class="exemplo_txt">Exemplo</span></p>
                                <p class="paragraph"><strong>Valor Anual:</strong><span class="exemplo_txt">Exemplo</span></p>
                                <p class="paragraph"><strong>Fiscal e-Gov:</strong><span class="exemplo_txt">Exemplo</span></p>
                                <p class="paragraph"><strong>Fiscal Adm:</strong><span class="exemplo_txt">Exemplo</span></p>
                            </div>
                            <div class="right">
                                <p class="paragraph"><strong>Objeto</strong></p>
                                <p class="tamanhoFonte">Lorem ipsum dolor sit amet,
                                    consectetur adipiscing elit.
                                    Nunc sit amet molestie lorem.
                                    Phasellus vehicula semper est, eu lobortis mi scelerisque quis.
                                    Curabitur nisl erat, posuere eu nibh sit amet, ultricies aliquam odio.
                                    Sed fermentum mauris eget lorem dictum, quis bibendum mi mollis.
                                    In hac habitasse platea dictumst.
                                </p>
                                <p class="paragraph"><strong>Detalhes e Observações</strong></p>
                                <p class="tamanhoFonte">Lorem ipsum dolor sit amet,
                                    consectetur adipiscing elit.
                                    Nunc sit amet molestie lorem.
                                    Phasellus vehicula semper est,
                                    eu lobortis mi scelerisque quis.
                                    Curabitur nisl erat, posuere eu nibh sit amet,
                                    ultricies aliquam odio. Sed fermentum mauris eget lorem dictum,
                                    quis bibendum mi mollis. In hac habitasse platea dictumst.
                                </p>
                            </div>
                        </div>
                        <div class="bottom">
                            <div class="bottom-left">
                                <p class="tituloBottom"><strong>Gestores:</strong></p>
                                <p class="inputSup">Exemplo</p>
                            </div>
                            <div class="bottom-right">
                                <p class="tituloBottom"><strong>Secretaria:</strong></p>
                                <p class="inputSup">Exemplo</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <span class="doc_contrato"><strong>Documentos do Contrato</strong></span>
                            <button type="submit" class="btn_anexo">Anexe Aqui</button>
                        </div>
                        <div class="bottom">
                            <div class="bottom-left">
                                <p class="tituloBottom"><strong>Categoria:</strong></p>
                                <p class="inputSup">Exemplo</p>
                            </div>
                            <div class="bottom-right">
                                <p class="tituloBottom"><strong>Nome Comercial:</strong></p>
                                <p class="inputSup">Exemplo</p>
                            </div>
                        </div>
                    </form>
                </div> -->
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
    
        <a href="../TelaAtivos/#" class="icon-middle"><span class="material-symbols-outlined">contract</span></i><span class="icon-text"> Contratos</span></a>
    
        <a href="#" class="icon-middle"><span class="material-symbols-outlined">inventory_2</span><span class="icon-text"> Arquivados</span></a>

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


<div id="modaleditar" class="modal">
    <div class="modal-content">
        <span id="closeEditar" class="close" >&times;</span>
        <div class="container" id="mostrarEditar">
            <!-- <form action="" method="POST">
                <input class="titulo" placeholder="Titulo">
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
                        <textarea class="tamanhoFonte2" rows="6" cols="50">Lorem ipsum dolor sit amet,
                            consectetur adipiscing elit.
                            Nunc sit amet molestie lorem.
                            Phasellus vehicula semper est, eu lobortis mi scelerisque quis.
                            Curabitur nisl erat, posuere eu nibh sit amet, ultricies aliquam odio.
                            Sed fermentum mauris eget lorem dictum, quis bibendum mi mollis.
                            In hac habitasse platea dictumst.
                        </textarea>
                        <p class="paragraph3"><strong>Detalhes e Observações:</strong></p>
                        <textarea class="tamanhoFonte2" rows="6" cols="50">Lorem ipsum dolor sit amet,
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
                    <span class="doc_contrato2"><strong>Documentos do Contrato</strong></span>
                    <button type="submit" class="btn_anexo2">Anexe Aqui</button>
                </div>
                <div class="bottom2">
                    <div class="bottom-left2">
                        <p class="tituloInput"><strong>Categoria:</strong></p>
                        <input type="text" class="inputBottom">
                    </div>
                    <div class="bottom-right2">
                        <p class="tituloInput"><strong>Nome Comercial:</strong></p>
                        <input type="text" class="ex_borda3">
                    </div>
                </div> -->
                <div class="salvar">
                    <button type="button" onclick="salvar()" class="button_save">Salvar</butto>
                </div>
                <div class="row justify-content-center">
                    <div class="closeEditar">
                        <button type="button" onclick="cancelar()" class="button_save">Cancelar</button>
                    </div>
                </div>
                
            <!-- </form> 
        </div>
    </div>
</div> -->



<script>
    document.addEventListener('DOMContentLoaded', function () {
    fetchContratos();
    addModalEventListeners();
});

    function addModalEventListeners() {
        var editarBtns = document.querySelectorAll('.btnedit'); // Seleciona todos os botões de edição
        var modal = document.getElementById('modaleditar');
        var close = document.getElementById('closeEditar');

        editarBtns.forEach(function(editarBtn) {
            editarBtn.addEventListener('click', function() {
                modal.style.display = 'block';
            });
        });

        if (close) {
            close.addEventListener('click', function() {
                modal.style.display = 'none';
            });
        } else {
            console.error('Elemento closeEditar não encontrado');
        }

        window.addEventListener('click', function(event) {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        });
    }

    function trocarDisplayModal(value) {
        // Configure a chamada AJAX
        var formData = new FormData();
        formData.append('codigo', value);

        xhr3 = new XMLHttpRequest();
        xhr3.open('POST', 'buscarDadosEdicao.php', true);
        xhr3.onreadystatechange = function () {
            if (xhr3.readyState === 4 && xhr3.status === 200) {
                console.log(xhr3.responseText); // Adicione este log para verificar a resposta
                let string = xhr3.responseText;
                document.getElementById('mostrarEditar').innerHTML = string;
                document.getElementById('modaleditar').style.display = 'block';
                setupFileInput('documentos', 'fileList');
                // Re-adicionar os event listeners ao conteúdo carregado
                addModalEventListeners();
            }
        }
        xhr3.send(formData);
    }
   
    function trocarDisplay(value) {
            // Obtenha a div com o id mostrar+value
            const div = document.getElementById('mostrar' + value);

            // Verifique se a div está visível
            if (div.style.display === 'none' || div.style.display === '') {
                // Configure a chamada AJAX
                var formData = new FormData();
                formData.append('codigo', value);

                xhr3 = new XMLHttpRequest();
                xhr3.open('POST', 'buscarDados.php', true);

                xhr3.onreadystatechange = function () {
                    if (xhr3.readyState === 4 && xhr3.status === 200) {
                        let string = xhr3.responseText;
                        div.innerHTML = string;
                        
                        addModalEventListeners();
                        div.style.display = 'block'; // Torna a div visível
                    }
                }
                xhr3.send(formData);
            } else {
                // Se a div já estiver visível, esconda-a
                div.style.display = 'none';
            }
        }

    function fetchContratos() {
        fetch('fetch_data.php')
            .then(response => response.json())
            .then(data => {
                const container = document.querySelector('.tudo');
                data.forEach(contract => {
                    const contractDiv = `

                        <button class="btn contratos ${contract.classificacaoContrato}" onclick="trocarDisplay(${contract.idContrato});">
                            ${contract.nomeUsual}
                            <div class="inner-btn" onclick="desarquivarContrato(${contract.idContrato}, event);">Desarquivar</div>
                        </button>
                            


                        <div id="mostrar${contract.idContrato}" class="hidden"></div>
                    `;
                    container.innerHTML += contractDiv;
                });
            })
            .catch(error => console.error('Erro ao buscar dados:', error));
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
        }
    );

   function desarquivarContrato(idContrato, event) {
    event.stopPropagation(); // Impede a propagação do evento de clique para o botão pai

    Swal.fire({
        title: 'Tem certeza?',
        text: "Você está prestes a desarquivar este contrato!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, desarquivar!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('desarquivar.php', {
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
                        'Desarquivado!',
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
                Swal.fire('Erro', 'Erro ao desarquivar contrato.', 'error');
            });
        }
    });
}

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

function confirmarApagarContrato(value) {
    // Exibir o alerta de confirmação
    Swal.fire({
        title: 'Tem certeza?',
        text: 'Você deseja realmente apagar este contrato?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sim, apagar',
        cancelButtonText: 'Não, cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Se o usuário confirmar, chama a função para apagar o contrato
            apagarContrato(value);
        }
    });
}

function apagarContrato(value) {
    var formData = new FormData();
    formData.append('codigo', value);
    var xhr3 = new XMLHttpRequest();
    xhr3.open('POST', 'apagarContrato.php', true);
    xhr3.onreadystatechange = function () {
        if (xhr3.readyState === 4) { 
            if (xhr3.status === 200) {
                let string = xhr3.responseText;  
                console.log('Contrato deletado com sucesso:', string);
                Swal.fire('Deletado!', 'O contrato foi apagado com sucesso.', 'success');
                window.location.href = 'https://pgs.pmf.sc.gov.br/TelaArquivados/#';
            } else {
                console.error('Erro ao deletar o contrato:', xhr3.statusText);
                Swal.fire('Erro!', 'Ocorreu um erro ao apagar o contrato.', 'error');
            }
        }
    };
    xhr3.send(formData);
}


</script>


<script src="script.js"></script>

</body>
</html>