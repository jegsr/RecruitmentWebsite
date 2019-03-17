function visualizar() {
    window.location.href = './visualizarOferta.php?id=' + this.parentNode.getAttribute('id');
}

function visualizarPerfil() {
    window.location.href = './perfil.php?id=' + this.parentNode.getAttribute('id');
}

function eliminarUtilizador() {
    $.post('./gerirUtilizador.php', {'gerir': 'eliminar', 'id': this.parentNode.getAttribute('id')}, function (data) {
        document.getElementById(data).remove();
    });
}

function desativarOferta(){
    
    $.post('./gerirUtilizador.php', {'gerir': 'desativar', 'id': this.parentNode.getAttribute('id')}, function (data) {
        alert(data);
        document.getElementById(data).remove();
    });
}

function selecionarCandidato(){
    $.post('./gerirUtilizador.php', {'gerir': 'selecionar', 'id': this.parentNode.getAttribute('id')}, function (data) {
    });
}

function initEvent() {
    var visualizar = document.getElementsByClassName('visualizar')
    if (visualizar.length > 0) {
        for (var i = 0; i < visualizar.length; i++)
            visualizar[i].addEventListener('click', visualizar);
    }
    visualizar = Array();
    visualizar = document.getElementsByClassName('visualizarPerfil')
    if (visualizar.length > 0) {
        for (var i = 0; i < visualizar.length; i++)
            visualizar[i].addEventListener('click', visualizarPerfil);
    }
    visualizar = Array();
    visualizar = document.getElementsByClassName('eliminarUtilizador');
    if (visualizar.length > 0) {
        for (var i = 0; i < visualizar.length; i++)
            visualizar[i].addEventListener('click', eliminarUtilizador);
    }
    visualizar = Array();
    visualizar = document.getElementsByClassName('desativar');
    if (visualizar.length > 0) {
        for (var i = 0; i < visualizar.length; i++)
            visualizar[i].addEventListener('click', desativarOferta);
    }
    visualizar = document.getElementsByClassName('selecionar');
    if (visualizar.length > 0) {
        for (var i = 0; i < visualizar.length; i++)
            visualizar[i].addEventListener('click', selecionarCandidato);
    }
    
}

document.addEventListener('DOMContentLoaded', initEvent);
