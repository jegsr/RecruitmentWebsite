




function alterarFormulario() {
    $.post('./Resource/JavaScript/validarRegisto.php', {'registo': this.getAttribute('value')}, function (data) {

        if (data == 'Prestador de Serviço') {
            document.getElementById('nome').innerHTML = 'Nome Completo';
            if (document.getElementsByClassName('prestador').length == 0) {
                var label = document.createElement('label');
                label.setAttribute('for', 'fileToUpload');
                label.setAttribute('class', 'prestador');
                label.innerHTML = 'Foto de Perfil';

                var input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('id', 'fileToUpload');
                input.setAttribute('name', 'fileToUpload');
                input.setAttribute('class', 'prestador');
                input.setAttribute('required', 'true');

                document.getElementById('cp').parentNode.appendChild(label);
                document.getElementById('cp').parentNode.appendChild(input);
            }
        } else {
            document.getElementById('nome').innerHTML = 'Nome Empresa';
            
            if (document.getElementsByClassName('prestador').length > 0) {
                
               document.getElementsByClassName('prestador')[0].remove();
               document.getElementById('fileToUpload').remove();
               
            }
        }
    }
    );
}




function initEvent() {
    var arrayTipoUtilizador = document.getElementsByName('tipoUtilizador');

    for (var i = 0; i < arrayTipoUtilizador.length; i++) {
        arrayTipoUtilizador[i].addEventListener('click', alterarFormulario);
    }

}

document.addEventListener('DOMContentLoaded', initEvent);


