
function removerOferta(id) {
    var array = JSON.parse(localStorage['ofertasTemporarias']);
    array.splice(id, 1);

    if (array.length > 0) {
        localStorage.setItem('ofertasTemporarias', JSON.stringify(array));
    } else {
        localStorage.removeItem('ofertasTemporarias');
    }

}

function editarOfertaTemporaria() {
    var id = this.parentNode.getAttribute('id');

    var json = JSON.parse(localStorage['ofertasTemporarias']);

    var key = Object.keys(json[id]);
    var str = "criarOfertas.php?";
    for (var j = 0; j < key.length; j++) {
        str += key[j] + '=' + json[id][key[j]];
        if (j < (key.length - 1)) {
            str += '&';
        }
    }

    removerOferta(id);
    window.location.href = str;
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
    var parent = document.getElementById('rodape');

    var section = document.createElement('section');
    section.setAttribute('id', 'ofertasEmprego');

    if (localStorage.getItem("ofertasTemporarias") == null && localStorage.getItem("ofertasTemporarias") == undefined) {
        var erro = document.createElement('h1');
        erro.setAttribute('class', 'erro');
        erro.innerHTML = "Nao existe ofertas guardadas";
        section.appendChild(erro);


    } else {
        var json = JSON.parse(localStorage['ofertasTemporarias']);


        for (var i = 0; i < json.length; i++) {

            var article = document.createElement('article');
            var fieldSet = document.createElement('fieldset');
            article.setAttribute('class', 'oferta');
            article.setAttribute('id', i);
            var key = Object.keys(json[i]);
            for (var j = 0; j < key.length; j++) {

                var h1 = document.createElement('h1');
                switch (key[j]) {
                    case 'categoriaespecifica':
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
            var button = document.createElement('button');
            button.setAttribute('class', 'editar');
            button.innerHTML = "Editar";
            button.addEventListener('click', editarOfertaTemporaria);
            article.appendChild(button);

            var button2 = document.createElement('button');
            button2.setAttribute('class', 'eliminar');
            button2.innerHTML = "Eliminar";
            button2.addEventListener('click', removeOfertaTemporaria);

            article.appendChild(button2);
            section.pappendChild(article);
        }

    }
    parent.parentNode.insertBefore(section, parent);
}

function initEvent() {
    gestorOfertasTemporarias();

}

document.addEventListener('DOMContentLoaded', initEvent);


