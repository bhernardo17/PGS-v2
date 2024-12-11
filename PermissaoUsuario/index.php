<?php
    include('../db/protect.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- ADICIONAR:     //   EDIÇÃO -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permissão</title>
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

        .show {
            display: flex;
        }

        .meio {
            text-align: center;
            justify-content: center;
        }

        .search-bar {
            margin-top: 2%;
            margin-bottom: 2%;
            width: 100%;
        }

        .search-bar input[type="text"] {
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 20%;
            box-sizing: border-box;
            margin-bottom: 5px;
        }   

        .geral{
            align-items: center;

        }
        .modal-content {
            align-items: center;
            margin: 10%;
            margin-left: 30%;
            padding: 20px;
            z-index: 1;
            left: 0;
            top: 0;
            width: 30%;
            height: 70%;
            background-color: #f0f0f0;
            border-radius: 3%;
            z-index: 9000;
            box-shadow: 0 0 40px rgba(8, 7, 16, 0.6);
        }

        .modalAdicionar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .modalAdicionar .adicionar {
            margin: 15% auto;
            align-items: center;
            padding: 20px;
            width: 30%;
            height: 70%;
            background-color: #f0f0f0;
            border-radius: 3%;
            z-index: 9000;
            box-shadow: 0 0 40px rgba(8, 7, 16, 0.6);
        }
        .botao1{
            width: 30%;
            height: 15%;
            border-radius: 8px;
            padding:1%;
            margin:1%;
            margin-left: 12%;
            font-size: 16px;
            cursor: pointer;
            border: none;
            color: white;
            background-color: rgba(43, 43, 100, 1);
            transition: background-color 0.3s ease-in-out;
        }
        
        .botao2{
            width: 80%;
            height: 15%;
            border-radius: 8px;
            padding:2%;
            margin:1%;
            font-size: 14px;
            cursor: pointer;
            border: none;
            color: white;
            background-color: rgba(43, 43, 100, 1);
            transition: background-color 0.3s ease-in-out;
        }
        .botao3{
            width: 50%;
            border-radius: 8px;
            padding:1%;
            margin:1%;
            font-size: 16px;
            cursor: pointer;
            border: none;
            color: white;
            background-color: rgba(43, 43, 100, 1);
            transition: background-color 0.3s ease-in-out;
        }
        .inputedit{
            border: none;
            outline: none;
            background: white;
        }

        .botaoAdicionar{
            border-radius: 20%;
            margin-left: 0.1%;
            width: 30px;
            margin-bottom: 0.4%;
        }

    </style>
</head>
<body>

    <div class="centro">
        <div class="geral">
            <br><br><br>
            <div class="meio">
                <h1 class="meio">Usuários</h1>
            </div>
            <div class="search-bar">
                <input id="search-input" type="text" placeholder="Pesquisar...">
                <button id="show-button" class="botaoAdicionar">+</button>
            </div>
            <div class="usuarios" id="usuarios">
            </div>
        </div>
    </div>

    <div class="modalAdicionar hidden" id="add-user-div">
        <div class="adicionar">
            <form action="adicionar.php" method="POST">
                <p class="paragraph">Nome: <input type="text" class="inputedit" name="nome"></p>
                <p class="paragraph">Matricula: <input type="text" class="inputedit" name="matricula"></p>
                <p class="paragraph">Telefone: <input type="text" class="inputedit" name="telefone"></p>
                <p class="paragraph">E-Mail: <input type="text" class="inputedit" name="e-mail"></p>
                <p class="paragraph">Secretaria: <input type="text" class="inputedit" name="nomeSecretaria"></p>
                <p class="paragraph">Senha Usuario: <input type="password" class="inputedit" name="senha" id="passw"></p>
                <p class="paragraph">Repita a Senha: <input type="password" class="inputedit" name="senhaRepetida" id="passw2"> </p>
                <label for="permissao">Permissão Usuario</label>
                <select name="permissao">
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                </select>
                <br>
                <div class="botoes"> 
                    <button class="botao1" type="submit">Salvar</button>
                    <button class="botao1" id="cancel-button" type="button">Cancelar</button>
                </div>
            </form>
        </div>
    </div>



    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="#" onclick="toggleSidebar()">☰</a><img src="../imagens/icondash.jpg" class="icondash" style="width: 50%;">
        </div>
        <a href="../TelaDashboard/#" class="icon-middle"><span class="material-symbols-outlined">grid_view</span><span class="icon-text"> Dashboard</span></a>

        <a href="../TelaCadastros/#" class="icon-middle"><span class="material-symbols-outlined">how_to_reg</span><span class="icon-text"> Cadastrar</span></a>

        <a href="../CadastroContratos/#" class="icon-middle"><span class="material-symbols-outlined">add</span><span class="icon-text" >Adicionar</span></a>

        <a href="../TelaAtivos/#" class="icon-middle"><span class="material-symbols-outlined">contract</span></i><span class="icon-text"> Contratos</span></a>

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


<script>
    document.addEventListener('DOMContentLoaded', function () {
        fetchContratos();
    });

    function fetchContratos() {
        fetch('fetch_data.php')
        .then(response => response.json())
        .then(data => {
            const container = document.querySelector('.usuarios');
            data.forEach(usuario => {
                const contractDiv = `
                    <button class="btn contratos" onclick='openModal("${usuario.idUsuario}")'>
                        ${usuario.nomeUsuario} - Nível de Acesso: ${usuario.permissaoUsuario} - Matrícula: ${usuario.matriculaUsuario}
                    </button>

                    <div id="${usuario.idUsuario}" class="modal">
                        <div class="modal-content">
                            <span class="close" onclick="closeModal('${usuario.idUsuario}')">&times;</span>
                            <div class="modal-view">
                                <p class="paragraph">Nome: ${usuario.nomeUsuario}</p>
                                <p class="paragraph">Matricula: ${usuario.matriculaUsuario}</p>
                                <p class="paragraph">Permissão Usuário: ${usuario.permissaoUsuario}</p>
                                <p class="paragraph">Telefone: ${usuario.telefone}</p>
                                <p class="paragraph">E-Mail: ${usuario.emailUsuario}</p>
                                <div class="ficaRETO">
                                    <button class="botao3" onclick='deletarUsuario("${usuario.idUsuario}", event)'>Remover</button>
                                    <button class="botao3" onclick='toggleEditForm("${usuario.idUsuario}")'><span class="material-symbols-outlined">border_color</span>Editar</button>
                                </div>
                            </div>
                            
                            <div class="modal-edit" style="display: none;">
                                <form action="editar.php"  method="POST">
                                <p class="paragraph">Nome: <input type="text" class="inputedit" name="nome" value="${usuario.nomeUsuario}"></p>
                                <p class="paragraph">Matricula: <input type="text" class="inputedit" name="matricula" value="${usuario.matriculaUsuario}"></p>
                               
                                <p class="paragraph">Telefone: <input type="text" class="inputedit" name="telefone" value="${usuario.telefone}"></p>
                                <p class="paragraph">E-Mail: <input type="text" class="inputedit" name="e-mail" value="${usuario.emailUsuario}"></p>
                                <p class="paragraph">Secretaria: <input type="text" class="inputedit" name="nomeSecretaria" value="${usuario.secretaria}"></p>
                                <input style="display: none;" type="text" name="idUsuario" value="${usuario.idUsuario}">
                                
                                <label for="permissao">Permissão Usuario</label> 
                                <select name="permissao">
                                    <option value="${usuario.permissaoUsuario}">Atual</option>
                                    <option value="0">0</option>
                                    <option value="1">1</option>    
                                    <option value="2">2</option>    
                                    <option value="3">3</option>        
                                </select>    
                                <br>
                                <button type="submit" class="botao2">Salvar</button>
                                <button type="button" class="botao2" onclick='toggleEditForm("${usuario.idUsuario}")'>Cancelar</button>
                                <button type="button" class="botao2" onclick='resetSenha("${usuario.idUsuario}", event)'> Resetar Senha</button>
                                </form>
                            </div>
                        </div>
                    </div>
                `;
                container.innerHTML += contractDiv;
                });
            })
            .catch(error => console.error('Erro ao buscar dados:', error));
    }

    function openModal(modalId) {
        document.getElementById(modalId).style.display = "block";
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.style.display = "none";
        const viewContent = modal.querySelector('.modal-view');
        const editContent = modal.querySelector('.modal-edit');
        viewContent.style.display = 'block';
        editContent.style.display = 'none';
    }

    function toggleEditForm(modalId) {
        const modal = document.getElementById(modalId);
        const viewContent = modal.querySelector('.modal-view');
        const editContent = modal.querySelector('.modal-edit');

        if (viewContent.style.display === 'none') {
            viewContent.style.display = 'block';
            editContent.style.display = 'none';
        } else {
            viewContent.style.display = 'none';
            editContent.style.display = 'block';
        }
    }

    document.getElementById('search-input').addEventListener('input', function() {
            const searchValue = this.value.toUpperCase();
            const buttons = document.querySelectorAll('.usuarios .contratos');
            
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

    document.getElementById('show-button').addEventListener('click', function() {
            document.getElementById('add-user-div').classList.remove('hidden');
            document.getElementById('add-user-div').classList.add('show');
    });

    document.getElementById('cancel-button').addEventListener('click', function() {
        document.getElementById('add-user-div').classList.remove('show');
        document.getElementById('add-user-div').classList.add('hidden');
    });

    function resetSenha(idUsuario, event) {
    event.stopPropagation(); // Impede a propagação do evento de clique para o botão pai

    Swal.fire({
        title: 'Tem certeza?',
        text: "Você está prestes a Resetar a Senha deste usuário!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, resetar!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('resetarSenha.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `idUsuario=${idUsuario}`
            })
            .then(response => response.text())
            .then(text => {
                console.log('Resposta bruta:', text); 
                let data;
                try {
                    data = JSON.parse(text);
                } catch (e) {
                    throw new Error('Resposta JSON inválida: ' + text);
                }
                if (data.status === 'success') {
                    Swal.fire(
                        'Senha Resetada!',
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
                Swal.fire('Erro', 'Erro ao Resetar a Senha do usuário.', 'error');
            });
        }
    });
}

function deletarUsuario(idUsuario, event) {
    event.stopPropagation(); // Impede a propagação do evento de clique para o botão pai

    Swal.fire({
        title: 'Tem certeza?',
        text: "Você está prestes a deletar este usuário!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, deletar!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('deletar.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `idUsuario=${idUsuario}`
            })
            .then(response => response.text())
            .then(text => {
                console.log('Resposta bruta:', text); // Log da resposta bruta
                let data;
                try {
                    data = JSON.parse(text);
                } catch (e) {
                    throw new Error('Resposta JSON inválida: ' + text);
                }
                if (data.status === 'success') {
                    Swal.fire(
                        'Deletado!',
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
                Swal.fire('Erro', 'Erro ao deletar usuário.', 'error');
            });
        }
    });
}




</script>
    
<script src="script.js"></script>

</body>
</html>