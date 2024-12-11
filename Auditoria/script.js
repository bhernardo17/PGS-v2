// Sidebar toggle
function toggleSidebar() {
  var sidebar = document.getElementById('sidebar');
  sidebar.classList.toggle('open');
}

// Função para abrir o modal de Logout usando estilo manual
function abrirModalSair() {
  document.getElementById("modalExit").style.display = "block";
  document.getElementById("body").style.backgroundColor = "rgba(0, 0, 0, 0.5)";
}

// Função para fechar qualquer modal que utiliza estilo manual
function fecharModal() {
  document.getElementById("modalExit").style.display = "none";
  document.getElementById("body").style.backgroundColor = "";
}

// Evento de clique para abrir modal de Logout
document.getElementById("botaoExit").addEventListener("click", abrirModalSair);

// Evento de clique no botão de fechar do modal de Logout
document.querySelectorAll("#voltar").forEach(function (element) {
  element.addEventListener("click", function () {
      fecharModal();
  });
});
