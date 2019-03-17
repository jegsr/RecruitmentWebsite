
function removerOferta(id) {
    var array = JSON.parse(localStorage['ofertasFavoritas']);
    array.splice(id, 1);

    if (array.length > 0) {
        localStorage.setItem('ofertasTemporarias', JSON.stringify(array));
    } else {
        localStorage.removeItem('ofertasTemporarias');
    }

}
function visualizar() {
    window.location.href = './visualizarOferta.php?id=' + this.parentNode.getAttribute('id');
}

function removeOfertaTemporaria() {

    var id = this.parentNode.getAttribute('id');

    removerOferta(id);

    this.parentNode.remove();

    var array = document.getElementsByTagName('article');

    for (var i = id; i < array.length; i++) {
        document.getElementsByTagName('article')[i].setAttribute('id', i);
    }
}

function gestorOfertasTemporarias() {
    var section = document.createElement('section');
    section.setAttribute('id', 'ofertasEmprego');
    
    var parent = document.getElementById('rodape');
    if (localStorage.getItem("ofertasFavoritas") == null && localStorage.getItem("ofertasFavoritas") == undefined) {

        var erro = document.createElement('h1');
        erro.setAttribute('class', 'erro');
        erro.innerHTML = "Nao existe ofertas favoritas";
        section.appendChild(erro);


    } else {
        var json = JSON.parse(localStorage['ofertasFavoritas']);
        



        for (var i = 0; i < json.length; i++) {

            var article = document.createElement('article');
            var fieldSet = document.createElement('fieldset');
            article.setAttribute('class', 'oferta');
            article.setAttribute('id', json[i]['id']);
            var key = Object.keys(json[i]);
            for (var j = 0; j < key.length; j++) {

                var h1 = document.createElement('h1');
                switch (key[j]) {
                    case 'ofertasFavoritas':
                        h1.innerHTML = 'categoria especifica: ';
                        break;
                    case 'dataInicio':
                        h1.innerHTML = 'data inicio: ';
                        break;
                    case 'dataFim':
                        h1.innerHTML = 'data fim: ';
                        break;
                    case 'tipoHorario':
                        h1.innerHTML = 'tipo horario: ';
                        break;
                    default:
                        h1.innerHTML = key[j] + ': ';
                }

                var h3 = document.createElement('h3');

                h3.innerHTML = json[i][key[j]];

                fieldSet.appendChild(h1);
                fieldSet.appendChild(h3);
            }
            article.appendChild(fieldSet);

            var button2 = document.createElement('button');
            button2.setAttribute('class', 'visualizar');
            button2.innerHTML = "Visualizar";
            button2.addEventListener('click', visualizar);

            var button2 = document.createElement('button');
            button2.setAttribute('class', 'eliminar');
            button2.innerHTML = "Eliminar";
            button2.addEventListener('click', removeOfertaTemporaria);

            article.appendChild(button2);
            section.appendChild(article);
        }
        
    }
    parent.parentNode.insertBefore(section, parent);
}

function initEvent() {
    gestorOfertasTemporarias();

}

document.addEventListener('DOMContentLoaded', initEvent);


