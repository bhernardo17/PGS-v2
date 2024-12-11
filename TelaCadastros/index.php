<?php
    include('../db/protect1.php');
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
<link rel="stylesheet" href="style.css">
</head>
<body>
  <body>
    <div id="overlay-background" class="overlay-background" style="display: none;"></div>
    <!-- Seu código existente continua aqui -->
</body>


<!-- Cabeçalho -->
<div class="header">
    <!-- <h1>Cadastro de Fornecedores e Usuários</h1> -->
</div>

<!-- Botões de cadastro -->
<div class="button-container">
    <button class="button" onclick="openOverlay('fornecedor')">Cadastrar Fornecedor</button>
    <button class="button" onclick="openOverlay('usuario')">Cadastrar Supervisor</button>
    <button class="button" onclick="openOverlay('secretaria')">Cadastrar Secretaria</button>
</div>

<!-- Pesquisa de contratos, falta alguns ajustes  -->
<div class="search-container">
  <div class="filter-icon" onclick="toggleFilterOptions()">
    <span class="material-symbols-outlined">filter_list</span>
  </div>
  
  <!-- Dropdown de opções de filtro -->
  <div id="filter-dropdown" class="filter-dropdown" style="display: none;">
    <ul>
        <li id="filter-all" value="Todos">Todos</li>
        <li id="filter-supervisor" value="Supervisor">Supervisor</li>
        <li id="filter-fornecedor" value="Fornecedor">Fornecedores</li>
        <li id="filter-secretaria" value="Secretaria">Secretaria/Autarquia</li>
    </ul>
</div>
  <input type="text" class="search-box" id="searchInput" placeholder="Digite sua pesquisa...">
  <!-- <button class="search-button" id="searchButton">Pesquisar</button> -->
   <!-- Ícone de filtro -->


</div>

<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <a href="#" onclick="toggleSidebar()">☰</a><img src="../imagens/icondash.jpg" class="icondash" style="width: 50%;">
    </div>
    <a href="../TelaDashboard/#" class="icon-middle"><span class="material-symbols-outlined">grid_view</span><span class="icon-text"> Dashboard</span></a>

    <a href="#" class="icon-middle"><span class="material-symbols-outlined">how_to_reg</span><span class="icon-text"> Cadastro</span></a>

    <a href="../CadastroContratos/#" class="icon-middle"><span class="material-symbols-outlined">add</span><span class="icon-text" >Adicionar</span></a>

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


<div class="content" id="container"></div>


<!-- Overlay para cadastro de fornecedores -->
<div id="overlay-fornecedor" class="overlay" style="display: none;">
  <div class="overlay-content">
      <!-- Início do formulário de cadastro de fornecedores -->
      <div id="cadastro">
          <form method="post" action="php/post_fornecedor.php">
            <h1>Cadastro de Fornecedor</h1> 
            
            <p> 
              <!--<label for="nome_cad"> Nome</label> -->
              <input name="nomeFornecedor" required="required" type="text" placeholder="Nome" />
            </p>
            
            <!-- <label for="email_cad"> E-mail</label> --> 
            <!-- <p> 
              <input id="emailFornecedor" name="email_cad" required="required" type="email" placeholder="E-mail"/> 
            </p> -->

            <p> 
              <!--<label for="rsocial_cad"> Razão Social</label> -->
              <input name="razaoFornecedor" required="required" type="text" placeholder="Razão Social"/>
            </p>

            <p>
              <!--<label for="cnpj_cad"> CNPJ</label> -->
              <input name="cnpjFornecedor" required="required" type="text" placeholder="CNPJ" />
            </p>

            <p>
              <!--<label for="suporteFornecedor"> CNPJ</label> -->
              <input name="suporteFornecedor" required="required" type="text" placeholder="Contato Suporte" />
            </p>

            <p> 
              <input type="submit" value="Cadastrar" onclick="cadastrarFornecedor()" />
            </p>

            <p>
              <button class="fecha" onclick="closeOverlay('fornecedor')">Fechar</button>
            </p>  
          </form>

      </div>
      <!-- Fim do formulário de cadastro de fornecedores -->
      
      <!-- Botão para fechar overlay de cadastro de fornecedores -->
      
  </div>
</div>

<!-- Overlay para cadastro de usuários -->
<div id="overlay-usuario" class="overlay" style="display: none;">
  <div id="overlay-background" class="overlay-background" style="display: none;"></div>

  <div class="overlay-content">
    <div id="cadastro2">
      <form method="POST" action="php/post_supervisor.php"> 
          <h2>Cadastro de Usuário</h2>
          
          <p> 
            <!--<label for="nome_usu"> Nome</label> -->
            <input name="nomeSupervisor" required="required" type="text" placeholder="Nome" />
          </p>
          
          <!-- <label for="email_usu"> E-mail</label> --> 
          <p> 
            <input name="emailSupervisor" required="required" type="text" placeholder="E-mail"/> 
          </p>
          
          <p> 
            <input name="secretariaSupervisor" required="required" type="text" placeholder="Secretaria"/>
          </p>

          <p>
            <!--<label for="telefone_cad"> Telefone</label> -->
            <input name="telefoneSupervisor" type="text" placeholder="Telefone" />
          </p>
          <p>
            <!--<label for="obs_cad"> Observação</label> -->
            <input name="matriculaSupervisor" required="required" type="text" placeholder="Matricula" />
          </p>

          <p> 
            <input type="submit" value="Cadastrar"/> 
          </p>

          <p>
            <button class="fecha" onclick="closeOverlay('usuario')">Fechar</button>
          </p>  
      </form>
    </div>
      
  </div>
</div>

<div id="overlay-secretaria" class="overlay" style="display: none;">
  <div class="overlay-content">
    <div id="cadastro3">
      <form method="post" action="php/post_secretaria.php"> 
        <h2>Cadastro de Secretaria/Autarquia</h2>
        
        <p> 
          <!--<label for="nome_usu"> Nome</label> -->
          <input name="nomeSecretaria" required="required" type="text" placeholder="Nome" />
        </p>
        
        <p> 
          <!-- <label for="email_usu"> E-mail</label> --> 
          <input name="siglaSecretaria" required="required" type="text" placeholder="Sigla"/> 
        </p>
        
        <p> 
          <input name="enderecoSecretaria" required="required" type="text" placeholder="Endereço"/>
        </p>

        <p>
          <!--<label for="telefone_cad"> Telefone</label> -->
          <input name="telefone_sec" required="required" type="text" placeholder=" Telefone" />
        </p>

        <p> 
          <input type="submit" value="Cadastrar"/> 
        </p>

        <p>
          <button class="fecha" onclick="closeOverlay('secretaria')">Fechar</button>
        </p>  
      </form>
    </div>
      
  </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="script.js"></script>
<!-- Adicione este script ao final do seu arquivo HTML -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    fetch('php/fetch_data.php')
    .then(response => response.json())
    .then(data => {
        const container = document.getElementById('container');

        // Tratar dados de supervisores
        data.supervisores.forEach(function(supervisor, index) {
            const modalId = `supervisorModal${index}`;
            container.innerHTML += `
              <div class="boxAuditoria" onclick='openModal("${modalId}")'>
                <div class="infoAuditoria"><i class="bi bi-clock" id="clock"></i>${supervisor.nomeSupervisor}</div>
                <div class="timeAuditoria"><p>Supervisor</p></div>
              </div>
              <div id="${modalId}" class="modal">
                <div class="modal-content">
                  <span class="close" onclick="closeModal('${modalId}')">&times;</span>
                  <div class="modal-view">
                    <div class="letras">
                      <p class="paragraph">Nome: ${supervisor.nomeSupervisor}</p>
                      <p class="paragraph">Email: ${supervisor.emailSupervisor}</p>
                      <p class="paragraph">Matrícula: ${supervisor.matriculaSupervisor}</p>
                      <p class="paragraph">Telefone: ${supervisor.telefoneSupervisor}</p>
                      <p class="paragraph">Secretaria: ${supervisor.nomeSecretaria}</p>
                      <button class="editar" onclick='toggleEditForm("${modalId}", ${JSON.stringify(supervisor)})'><span class="material-symbols-outlined">
                        border_color
                        </span>Editar</button>
                    </div>
                  </div>
                  <div class="modal-edit" style="display: none;">
                    <form action="edicaoCadastros.php" class="editandomano" method="POST">
                      <p class="paragraph">Nome: <input type="text" class="inputedit" name="nomeSupervisor" value="${supervisor.nomeSupervisor}"></p>
                      <p class="paragraph">Email: <input type="text" class="inputedit" name="email" value="${supervisor.emailSupervisor}"></p>
                      <p class="paragraph">Matrícula: <input type="text" class="inputedit" name="matricula" value="${supervisor.matriculaSupervisor}"></p>
                      <p class="paragraph">Telefone: <input type="text" class="inputedit" name="telefone" value="${supervisor.telefoneSupervisor}"></p>
                      <p class="paragraph">Secretaria: <input type="text" class="inputedit" name="secretariaSupervisor" value="${supervisor.nomeSecretaria}"></p>
                      <input style="display: none;" type="text" name="idSupervisor" value="${supervisor.idSupervisor}">
                      <button type="submit" class="buut" >Salvar</button>
                      <button type="button" onclick='toggleEditForm("${modalId}")'class="buut">Cancelar</button>
                    </form>
                  </div>
                </div>
              </div>
            `;
        });

        // Tratar dados de fornecedores
        data.fornecedor.forEach(function(fornecedor, index) {
            const modalId = `fornecedorModal${index}`;
            container.innerHTML += `
              <div class="boxAuditoria" onclick='openModal("${modalId}")'>
                <div class="infoAuditoria"><i class="bi bi-clock" id="clock"></i>${fornecedor.nomeFornecedor}</div>
                <div class="timeAuditoria"><p>Fornecedor</p></div>
              </div>
              <div id="${modalId}" class="modal">
                <div class="modal-content">
                  <span class="close" onclick="closeModal('${modalId}')">&times;</span>
                  <div class="modal-view">
                    <p class="paragraph">Nome: ${fornecedor.nomeFornecedor}</p>
                    <p class="paragraph">Razão Social: ${fornecedor.razaoFornecedor}</p>
                    <p class="paragraph">CNPJ: ${fornecedor.cnpjFornecedor}</p> 
                    <p class="paragraph">E-mail: ${fornecedor.emailFornecedor}</p>                     
                    <p class="paragraph">Suporte: ${fornecedor.suporteFornecedor}</p>
                    <button class="editar" onclick='toggleEditForm("${modalId}", ${JSON.stringify(fornecedor)})'><span class="material-symbols-outlined">
                        border_color
                        </span>Editar</button>
                  </div>
                  <div class="modal-edit" style="display: none;">
                    <form action="edicaoCadastros.php" class="editandomano" method="POST">
                      <p class="paragraph">Nome: <input type="text" class="inputedit" name="nomeFornecedor" value="${fornecedor.nomeFornecedor}"></p>
                      <p class="paragraph">Razão Social: <input type="text" class="inputedit" name="razao" value="${fornecedor.razaoFornecedor}"></p>
                      <p class="paragraph">CNPJ: <input type="text" class="inputedit" name="cnpj" value="${fornecedor.cnpjFornecedor}"></p>
                      <p class="paragraph">E-mail: <input type="text" class="inputedit" name="emailFornecedor" value="${fornecedor.emailFornecedor}"></p>
                      <p class="paragraph">Suporte: <input type="text" class="inputedit" name="suporteFornecedor" value="${fornecedor.suporteFornecedor}"></p>
                      <input style="display: none;" type="text" name="idFornecedor" value="${fornecedor.idFornecedor}">
                      <button type="submit" class="buut">Salvar</button>
                      <button type="button" onclick='toggleEditForm("${modalId}")' class="buut">Cancelar</button>
                    </form>
                  </div>
                </div>
              </div>
            `;
        });

        // Tratar dados de secretarias
        data.secretarias.forEach(function(secretaria, index) {
            const modalId = `secretariaModal${index}`;
            container.innerHTML += `
              <div class="boxAuditoria" onclick='openModal("${modalId}")'>
                <div class="infoAuditoria"><i class="bi bi-clock" id="clock"></i>${secretaria.siglaSecretaria} - ${secretaria.nomeSecretaria}</div>
                <div class="timeAuditoria"><p>Secretaria</p></div>
              </div>
              <div id="${modalId}" class="modal">
                <div class="modal-content">
                  <span class="close" onclick="closeModal('${modalId}')">&times;</span>
                  <div class="modal-view">
                    <p class="paragraph">Nome: ${secretaria.nomeSecretaria}</p>
                    <p class="paragraph">Sigla: ${secretaria.siglaSecretaria}</p>
                    <p class="paragraph">Endereço: ${secretaria.enderecoSecretaria}</p>
                    <p class="paragraph">Telefone: ${secretaria.telefoneSecretaria}</p>
                    <button class="editar" onclick='toggleEditForm("${modalId}", ${JSON.stringify(secretaria)})'><span class="material-symbols-outlined">
                        border_color
                        </span>Editar</button>
                  </div>
                  <div class="modal-edit" style="display: none;">
                    <form action="edicaoCadastros.php" class="editandomano" method="POST">
                      <p class="paragraph">Nome: <input type="text" class="inputedit" name="nomeSecretaria" value="${secretaria.nomeSecretaria}"></p>
                      <p class="paragraph">Sigla: <input type="text" class="inputedit" name="sigla" value="${secretaria.siglaSecretaria}"></p>
                      <p class="paragraph">Endereço: <input type="text" class="inputedit" name="endereco" value="${secretaria.enderecoSecretaria}"></p>
                      <p class="paragraph">Telefone: <input type="text" class="inputedit" name="telefone" value="${secretaria.telefoneSecretaria}"></p>
                      <input style="display: none;" type="text" name="idSecretaria" value="${secretaria.idSecretaria}">
                      <button type="submit" class="buut">Salvar</button>
                      <button type="button" onclick='toggleEditForm("${modalId}")' class="buut">Cancelar</button>
                    </form>
                  </div>
                </div>
              </div>
            `;
        });
    })
    .catch(error => console.error('Erro ao buscar dados:', error));
});

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
  
document.getElementById('searchInput').addEventListener('input', function() {
    var searchValue = this.value.toLowerCase();
    var container = document.getElementById('container');
    var boxes = container.getElementsByClassName('boxAuditoria');

    for (var i = 0; i < boxes.length; i++) {
        var info = boxes[i].getElementsByClassName('infoAuditoria')[0].textContent.toLowerCase();
        if (info.includes(searchValue)) {
            boxes[i].style.display = 'block';
        } else {
            boxes[i].style.display = 'none';
        }
    }
});

document.addEventListener('DOMContentLoaded', function() {
    var searchInput = document.getElementById('searchInput');
    var filterDropdown = document.getElementById('filter-dropdown');
    var container = document.getElementById('container');
    var boxes = container.getElementsByClassName('boxAuditoria');
    var currentFilter = 'Todos'; 

    function filterBoxes() {
        var searchValue = searchInput.value.toLowerCase();

        for (var i = 0; i < boxes.length; i++) {
            var info = boxes[i].getElementsByClassName('infoAuditoria')[0].textContent.toLowerCase();
            var time = boxes[i].getElementsByClassName('timeAuditoria')[0].textContent.toLowerCase();

            var matchesSearch = (info.includes(searchValue) || time.includes(searchValue));
            var matchesFilter = (currentFilter === 'Todos' || time.includes(currentFilter.toLowerCase()));

            if (matchesSearch && matchesFilter) {
                boxes[i].style.display = 'flex';
            } else {
                boxes[i].style.display = 'none';
            }
        }
    }


    searchInput.addEventListener('input', filterBoxes);

    function toggleFilterOptions() {
        if (filterDropdown.style.display === 'none' || filterDropdown.style.display === '') {
            filterDropdown.style.display = 'block';
        } else {
            filterDropdown.style.display = 'none';
        }
    }

    document.querySelector('.filter-icon').addEventListener('click', toggleFilterOptions);

    document.addEventListener('click', function(event) {
        var isClickInside = filterDropdown.contains(event.target) || event.target.closest('.filter-icon');

        if (!isClickInside) {
            filterDropdown.style.display = 'none';
        }
    });

    document.getElementById('filter-all').addEventListener('click', function() {
        currentFilter = 'Todos';
        filterBoxes();
        filterDropdown.style.display = 'none';
    });

    document.getElementById('filter-supervisor').addEventListener('click', function() {
        currentFilter = 'Supervisor';
        filterBoxes();
        filterDropdown.style.display = 'none'; 
    });

    document.getElementById('filter-fornecedor').addEventListener('click', function() {
        currentFilter = 'Fornecedor';
        filterBoxes();
        filterDropdown.style.display = 'none'; //
    });

    document.getElementById('filter-secretaria').addEventListener('click', function() {
        currentFilter = 'Secretaria';
        filterBoxes();
        filterDropdown.style.display = 'none'; 
    });
});

</script>
</body>
</html>


