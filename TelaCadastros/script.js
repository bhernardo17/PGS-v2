// Função para abrir o modal
function openOverlay(type) {
    var overlay = document.getElementById('overlay-' + type);
    var overlayBackground = document.getElementById('overlay-background');
    overlay.style.display = 'flex';
    overlayBackground.style.display = 'block';
    overlay.style.zIndex = '1'; // Garante que o modal esteja na frente da camada de fundo
}


// Função para fechar o modal
function closeOverlay(type) {
    var overlay = document.getElementById('overlay-' + type);
    var overlayBackground = document.getElementById('overlay-background');
    overlay.style.display = 'none';
    overlayBackground.style.display = 'none';
}

// Adicionar ouvinte de evento de clique para fechar o modal ao clicar fora dele
document.getElementById('overlay-background').addEventListener('click', function(event) {
    var overlayContent = document.querySelector('.overlay-content');
    if (!overlayContent.contains(event.target)) {
        closeOverlay('fornecedor');
        closeOverlay('usuario');
        closeOverlay('secretaria');
    }
});

function toggleSidebar() {
    var sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('open');
}


function applyFilter(filterValue) {
    // Implemente a lógica para aplicar o filtro com o valor selecionado
    console.log('Filtro aplicado:', filterValue);

    // Oculta o dropdown após selecionar uma opção
    var filterDropdown = document.getElementById('filter-dropdown');
    filterDropdown.style.display = 'none';
}


// Adicionar um ouvinte de evento de clique ao botão de pesquisa
document.getElementById('searchButton').addEventListener('click', search);

