function salvar() {
    // Coloque aqui o código para salvar os dados
    alert("Dados salvos!");
}

function cancelar() {
    // Coloque aqui o código para cancelar
    alert("Operação cancelada!");
}

function toggleSidebar() {
    var sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('open');
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

            if (xhr3.readyState === 4 && xhr3.status === 200){                       
                
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
    limparCampos()
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
                if (document.getElementsByName('supStatus[]')[i].value == 'Status') ok = false;
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
        statusCampos[i].value = "Status";
    }
}