function toggleSidebar() {
  var sidebar = document.getElementById('sidebar');
  sidebar.classList.toggle('open');
}


// Função para abrir o modal
function openModal() {
  var modalEditar = document.getElementById('modalEditar');
  modalEditar.style.display = 'block';
}

// Função para fechar o modal
function closeModal() {
  var modalEditar = document.getElementById('modalEditar');
  modalEditar.style.display = 'none';
}

// Função para fechar o modal quando clicar fora dele
function clickOutsideModal(event) {
  var modalEditar = document.getElementById('modalEditar');
  if (event.target == modalEditar) {
    modalEditar.style.display = 'none';
  }
}
